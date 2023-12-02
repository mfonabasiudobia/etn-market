<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;

class ForgotPassword extends BaseComponent
{

    public $email;

    public function submit()
    {

        $this->validate([
            'email' => 'required|email'
        ]);

        try {

            throw_unless($user = AuthRepository::forgotPassword($this->email), "The email must be valid email address");

            toast()->success("A password reset link has been sent to your email")->push();
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }


    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
