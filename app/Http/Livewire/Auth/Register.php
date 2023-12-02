<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;
use Illuminate\Validation\Rules\Password;

class Register extends BaseComponent
{

    public $email, $password, $password_confirmation;

    public function submit()
    {

        $this->validate([
            'email' => 'required|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()]
        ]);


        $data = [
            'email' => $this->email,
            'password' => $this->password
        ];

        try {

            throw_unless($user =  AuthRepository::register($data), "Failed to create your account");

            // throw_unless($otp = AuthRepository::sendOtp($user->email), "Failed to send OTP");

            toast()->success('Your account has been created')->pushOnNextPage();

            return redirect()->route("login");
        } catch (\Exception $e) {

            return toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.auth.register');
    }
}
