<?php

namespace App\Http\Livewire\Auth;

use App\Http\Livewire\BaseComponent;
use App\Repositories\AuthRepository;

class Login extends BaseComponent
{

    public $user, $email, $password, $rm;

    // public function mount(){
    //      if(request()->has('signature')){
    //         if (!request()->hasValidSignature()) {
    //             abort(401);
    //         }

    //         try {
    //             throw_unless(AuthRepository::verifyOtp([ 'email' => request('email') ]), "An error occured, please try again");

    //             toast()->success("Email has been verified")->pushOnNextPage();

    //         } catch (\Throwable $e) {
    //             toast()->danger($e->getMessage())->pushOnNextPage();
    //         }

    //      }
    // }

    public function submit()
    {

        try {
            if (AuthRepository::login(['email' => $this->email, 'password' => $this->password])) {

                return redirect()->route("login");
            } else {
                toast()->danger('Invalid Login Credentials')->push();
            }
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function resendVerificationMail()
    {
        // try {
        //     throw_unless(AuthRepository::sendOtp(session('confirmation-email')), "Failed to send email");

        //     toast()->success('Email has been sent!')->push();

        //     session()->flash('confirmation-email-message', true);

        //     $this->dispatchBrowserEvent('trigger-email-sent');

        // } catch (\Throwable $e) {
        //     toast()->danger($e->getMessage())->push();
        // }
    }

    public function logout()
    {
        auth()->logout();
        if (!auth()->check()) return redirect()->route('login');
    }


    public function render()
    {
        return view('livewire.auth.login');
    }
}
