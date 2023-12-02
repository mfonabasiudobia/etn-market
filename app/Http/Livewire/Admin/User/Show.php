<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\BaseComponent;
use App\Repositories\UserRepository;

class Show extends BaseComponent
{
    public $user;

    public $first_name, $other_name, $last_name, $mother_maiden_name, $mobile_number1, $mobile_number2;
    public  $blood_group, $genotype, $nationality, $state_of_origin, $lga, $national_identification_number;
    public $residential_address, $residential_country, $residential_state, $residential_lga, $residential_zipcode;
    public $emergency_name, $emergency_mobile_number1, $emergency_mobile_number2, $emergency_address;

    public function mount($id)
    {

        $this->user = UserRepository::getUserById($id);

        $this->fill([
            'first_name' =>  $this->user->first_name,
            'other_name' =>  $this->user->other_name,
            'last_name' =>  $this->user->last_name,

            'mother_maiden_name' =>  $this->user->mother_maiden_name,
            'mobile_number1' =>  $this->user->mobile_number1,
            'mobile_number2' =>  $this->user->mobile_number2,
            'blood_group' =>  $this->user->blood_group,
            'genotype' =>  $this->user->genotype,
            'nationality' =>  $this->user->nationality,
            'state_of_origin' => $this->user->state_of_origin,
            'lga' => $this->user->lga,
            'national_identification_number' =>  $this->user->national_identification_number,

            'residential_address' =>  $this->user->residential_address,
            'residential_country' =>  $this->user->residential_country,
            'residential_state' => $this->user->residential_state,
            'residential_lga' => $this->user->residential_lga,
            'residential_zipcode' => $this->user->residential_zipcode,

            'emergency_name' =>  $this->user->emergency_name,
            'emergency_mobile_number1' =>  $this->user->emergency_mobile_number1,
            'emergency_mobile_number2' =>  $this->user->emergency_mobile_number2,
            'emergency_address' => $this->user->emergency_address,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.user.show')->layout('layouts.admin-base');
    }
}
