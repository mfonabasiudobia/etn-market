<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Repositories\Admin\AuthRepository;
use App\Http\Livewire\BaseComponent;

class Login extends BaseComponent
{

    public $email, $password, $rm;

    // public function mount(){
    //     dd(storage_path('/'));
    // }

    public function submit()
    {

        $user = \App\Models\User::first();

        $user->assignRole('Super Admin');

        if (AuthRepository::login((object) ['email' => $this->email, 'password' => $this->password, 'rm' => $this->rm])) {
            redirect()->route('admin.dashboard');
        } else {
            toast()->danger('Invalid Login Credentials')->push();
        }
    }

    public function logout()
    {
        auth()->logout();
        if (!auth()->check()) return redirect()->route('admin.login');
    }

    public function render()
    {
        return view('livewire.admin.auth.login')->layout('layouts.admin-base');
    }
}
