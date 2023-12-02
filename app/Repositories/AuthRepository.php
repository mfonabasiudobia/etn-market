<?php

namespace App\Repositories;

use App\Models\User;
use App\Mail\OtpNotification;
use App\Mail\PasswordResetNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AuthRepository
{


    public static function login($data): User | null
    {
        $user = auth()->attempt($data);

        return auth()->user();
    }

    public static function register($data): User
    {
        $user = User::create(array_merge(
            $data,
            [
                'password' => bcrypt($data['password']),
                'unique_id' => self::uniqueCode()
            ]
        ));

        $user->assignRole('normal');

        return $user->refresh();
    }

    public static function uniqueCode(): string
    {
        $code = strtoupper(str()->random(5));

        if (User::where('unique_id', $code)->first()) $code = self::uniqueCode();

        return $code;
    }


    public static function forgotPassword($email): bool | int
    {

        $code = rand(111111, 999999);

        if ($user = self::getUserByEmail($email)) {

            //Send Forgot token Mail to User here
            $url = URL::temporarySignedRoute('reset_password', now()->addMinutes(15), ['email' => $email]);

            Mail::to($email)->send(new PasswordResetNotification($user, $url));


            return true;
        }

        return false;
    }

    public static function resetPassword($data): bool | User
    {

        if ($user = self::getUserByEmail($data['email'])) {

            $user->update([
                'password' => bcrypt($data['password'])
            ]);

            return $user;
        }

        return false;
    }


    public static function sendOtp($email, $temporaryToken = null): bool | int
    {
        $otp = rand(111111, 999999);

        if ($user = self::getUserByEmail($email, $temporaryToken)) {

            DB::table('otp_verifications')->where('email', $email)->delete(); //disable previous otps

            //Send Forgot token Mail to User here
            $url = URL::temporarySignedRoute('login', now()->addMinutes(15), ['email' => $email]);

            Mail::to($email)->send(new OtpNotification($user, $url));

            return  $otp;
        }

        return false;
    }

    public static function getUserByEmail($email, $temporaryToken = null): User | null
    {
        return User::where('email', $email)->when($temporaryToken, function ($q) use ($temporaryToken) {
            $q->where('temporary_token', $temporaryToken);
        })->first();
    }
}
