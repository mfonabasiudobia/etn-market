<?php

namespace App\Http\Livewire\Admin\Setting\BusinessSetting;

use App\Http\Livewire\BaseComponent;
use App\Repositories\SettingRepository;
use AppHelper;

class GeneralSettings extends BaseComponent
{

    public $name, $email, $phone_number, $address, $logo, $subscription_amount;

    public function mount()
    {
        // AppHelper::hasPermissionTo('manage_settings');

        $this->fill([
            'name' => gs()->business_name,
            'email' => gs()->email,
            'phone_number' => gs()->phone_number,
            'address' => gs()->address,
            'logo' => gs()->logo,
            'subscription_amount' => gs()->subscription_amount
        ]);
    }


    public function submit(SettingRepository $settingRepo)
    {

        try {

            $settingRepo->multipleUpdate([
                'business_name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'logo' => $this->logo,
                'subscription_amount' => $this->subscription_amount
            ]);

            $this->reset('logo');

            toast()->success("General Settings has been updated")->push();

            $this->emit('refresh');
        } catch (\Throwable $e) {

            toast()->danger("Failed to update General Settings")->push();
        }
    }


    public function render()
    {
        return view('livewire.admin.setting.business-setting.general-settings')->layout('layouts.admin-base');
    }
}
