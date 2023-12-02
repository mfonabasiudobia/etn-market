<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => "App\Http\Livewire"], function () {


    Route::get('logout', "Auth\Login@logout")->name('logout');

    Route::group(['middleware' => []], function () {

        Route::group(['namespace' => 'Auth', 'middleware' => ['UserAuth']], function () {
            Route::get('/', "Login")->name('login');
            Route::get('forgot-password', "ForgotPassword")->name('forgot_password');
            Route::get('reset-password', "ResetPassword")->name('reset_password');
            Route::get('signup', "Register")->name('register');
        });

        Route::group(['middleware' => ['UserAuth'], 'as' => 'user.', 'namespace' => 'User'], function () {
            Route::get('step1', "Dashboard\Home")->name('dashboard');
            Route::get('step2', "Step2\Home")->name('step2');

            Route::group(['namespace' => 'Transaction', "as" => "transaction.", "prefix" => "transaction"], function () {
                Route::get('list', "Home")->name('list');
                Route::get('{id}/details', "Show")->name('show');
            });
        });
    });
});
