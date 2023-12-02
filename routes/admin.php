<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => "App\Http\Livewire\Admin", "as" => "admin."], function () {


    Route::get('logout', "Auth\Login@logout")->name('logout');

    Route::group(['middleware' => ['AdminAuth']], function () {

        Route::get('/', "Auth\Login")->name('login');
        Route::get('dashboard', "Dashboard\Home")->name('dashboard');

        // Route::group(['namespace' => 'Permission', "as" => "permission.", "prefix" => "permission"], function () {
        //     Route::get('list', "Home")->name('list');
        //     Route::get('create', "Create")->name('create');
        //     Route::get('{id}/edit', "Edit")->name('edit');
        // });

        Route::group(['namespace' => 'Employee', "as" => "employee.", "prefix" => "employee"], function () {
            Route::get('list', "Home")->name('list');
            Route::get('create', "Create")->name('create');
            Route::get('{id}/edit', "Edit")->name('edit');
        });

        Route::group(['namespace' => 'User', "as" => "user.", "prefix" => "customer"], function () {
            Route::get('list', "Home")->name('list');
            Route::get('create', "Create")->name('create');
            Route::get('{id}/edit', "Edit")->name('edit');
            Route::get('{id}/show', "Show")->name('show');
        });

        Route::group(['namespace' => 'Role', "as" => "role.", "prefix" => "role"], function () {
            Route::get('list', "Home")->name('list');
            Route::get('create', "Create")->name('create');
            Route::get('{id}/edit', "Edit")->name('edit');
        });

        Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
            Route::get('/', "Gallery\Home")->name('home');
        });

        Route::group(['namespace' => 'Transaction', "as" => "transaction.", "prefix" => "transaction"], function () {
            Route::get('list', "Home")->name('list');
            Route::get('{id}/details', "Show")->name('show');
        });

        Route::group(['prefix' => 'setting', 'namespace' => 'Setting', "as" => "setting."], function () {
            Route::group(['prefix' => 'business-setting', 'namespace' => 'BusinessSetting', "as" => "business."], function () {
                Route::get('general', "GeneralSettings")->name('general');
                Route::get('app-config', "AppSettings")->name('app_config');
                Route::get('notification', "NotificationSettings")->name('notification');
                Route::get('transaction-messages', "TransactionMessage")->name('transaction_message');
            });

            Route::group(['prefix' => 'third-perty', 'namespace' => 'ThirdParty', "as" => "third_party."], function () {
                Route::get('mail-config', "MailConfig")->name('mail_config');
                Route::get('payment-method', "PaymentMethods")->name('payment_method');
                Route::get('sms-module', "SMSModule")->name('sms_module');
            });
        });
    });
});
