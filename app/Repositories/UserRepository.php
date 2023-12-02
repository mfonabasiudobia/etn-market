<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Hash;

class UserRepository
{


    public static function all(): LengthAwarePaginator
    {
        return User::paginate(20);
    }

    public static function getUserById(string $id): User
    {
        return User::findOrFail($id);
    }

    public static function createUser(array $data): User
    {
        $user = User::create(array_merge($data, ['password' => bcrypt($data['password'])]));

        $user->assignRole('normal');

        return $user;
    }

    public static function updateUser(array $data, string $id): User
    {
        $user = User::find($id);
        $user->update($data);

        return $user->refresh();
    }

    public static function updateProfileImage(array $data, string $id): User
    {
        $user = User::find($id);

        $user->update([
            'profile_image' => upload_file($data['profile_image'], 'profile')
        ]);

        return $user->refresh();
    }


    public static function resetPassword(array $data, string $id): bool | User
    {

        throw_unless(Hash::check($data['old_password'], auth()->user()->password), "Old Password does not match!");

        return auth()->user()->update([
            'password' => bcrypt($data['new_password'])
        ]);
    }

    public static function deleteAccount(string $id): bool
    {
        return User::find($id)->delete();
    }
}
