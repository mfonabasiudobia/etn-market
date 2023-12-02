<?php

namespace App\Http\Livewire\User\Dashboard;

use App\Http\Livewire\BaseComponent;
use App\Repositories\UserRepository;
use App\Helpers\AppHelper;
use App\Models\City;
use App\Models\State;
use App\Models\Country;

class Home extends BaseComponent
{
    public $first_name, $other_name, $last_name, $mother_maiden_name, $mobile_number1, $mobile_number2;
    public  $blood_group, $genotype, $nationality, $state_of_origin, $lga, $national_identification_number;
    public $residential_address, $residential_country, $residential_state, $residential_lga, $residential_zipcode;
    public $emergency_name, $emergency_mobile_number1, $emergency_mobile_number2, $emergency_address;

    public $profile_image;

    public $lgas1 = [], $lgas2 = [];

    public $states1 = [], $states2 = [];

    public function mount()
    {
        $user = auth()->user();

        $this->fill([
            'first_name' => $user->first_name,
            'other_name' => $user->other_name,
            'last_name' => $user->last_name,

            'mother_maiden_name' => $user->mother_maiden_name,
            'mobile_number1' => $user->mobile_number1,
            'mobile_number2' => $user->mobile_number2,
            'blood_group' => $user->blood_group,
            'genotype' => $user->genotype,
            'nationality' => $user->nationality,
            'state_of_origin' => $user->state_of_origin,
            'lga' => $user->lga,
            'national_identification_number' => $user->national_identification_number,

            'residential_address' => $user->residential_address,
            'residential_country' => $user->residential_country,
            'residential_state' => $user->residential_state,
            'residential_lga' => $user->residential_lga,
            'residential_zipcode' => $user->residential_zipcode,

            'emergency_name' => $user->emergency_name,
            'emergency_mobile_number1' => $user->emergency_mobile_number1,
            'emergency_mobile_number2' => $user->emergency_mobile_number2,
            'emergency_address' => $user->emergency_address
        ]);

        $this->updatedStateOfOrigin($user->state_of_origin);
        $this->updatedResidentialState($user->residential_state);
        $this->updatedNationality($user->nationality);
        $this->updatedResidentialCountry($user->residential_country);
    }

    public function updatedNationality($value)
    {
        $country = Country::where('name', $value)->first();

        if ($country) {
            $this->states1 = State::where('country_id', $country->id)->get();
        }
    }

    public function updatedResidentialCountry($value)
    {
        $country = Country::where('name', $value)->first();

        if ($country) {
            $this->states2 = State::where('country_id', $country->id)->get();
        }
    }

    public function updatedStateOfOrigin($value)
    {
        $state = State::where('name', $value)->where('country_id', 160)->first();

        if ($state) {
            $this->lgas1 = City::where("state_id", $state->id)->get();
        }
    }

    public function updatedResidentialState($value)
    {
        $state = State::where('name', $value)->where('country_id', 160)->first();

        if ($state) {
            $this->lgas2 = City::where("state_id", $state->id)->get();
        }
    }

    public function submit()
    {

        $this->validate([
            'first_name' => 'required',
            'other_name' => 'nullable',
            'last_name' => 'required',

            'mother_maiden_name' => 'required',
            'mobile_number1' => 'required',
            'mobile_number2' => 'nullable',

            'blood_group' => 'required',
            'genotype' => 'nullable',
            'nationality' => 'required',
            'state_of_origin' => 'required',
            'lga' => 'required',
            'national_identification_number' => 'required',

            'residential_address' => 'nullable',
            'residential_country' => 'nullable',
            'residential_state' => 'nullable',
            'residential_lga' => 'nullable',
            'residential_zipcode' => 'nullable',

            'emergency_name' => 'required',
            'emergency_mobile_number1' => 'required',
            'emergency_mobile_number2' => 'nullable',
            'emergency_address' => 'nullable',
        ], [
            'lga.required' => 'Local govt area is required'
        ]);



        try {
            $data = [
                'first_name' => $this->first_name,
                'other_name' => $this->other_name,
                'last_name' => $this->last_name,

                'mother_maiden_name' => $this->mother_maiden_name,
                'mobile_number1' => $this->mobile_number1,
                'mobile_number2' => $this->mobile_number2,
                'blood_group' => $this->blood_group,
                'genotype' => $this->genotype,
                'nationality' => $this->nationality,
                'state_of_origin' => $this->state_of_origin,
                'lga' => $this->lga,
                'national_identification_number' => $this->national_identification_number,

                'residential_address' => $this->residential_address,
                'residential_country' => $this->residential_country,
                'residential_state' => $this->residential_state,
                'residential_lga' => $this->residential_lga,
                'residential_zipcode' => $this->residential_zipcode,

                'emergency_name' => $this->emergency_name,
                'emergency_mobile_number1' => $this->emergency_mobile_number1,
                'emergency_mobile_number2' => $this->emergency_mobile_number2,
                'emergency_address' => $this->emergency_address,
                'profile_image' => AppHelper::uploadFile($this->profile_image, "/users", auth()->user()->profile_image, true)
            ];

            throw_unless(UserRepository::updateUser($data, auth()->id()), 'An error occured');

            toast()->success("Profile Information Updated")->push();

            redirect()->route("user.step2");
        } catch (\Throwable $e) {
            toast()->danger($e->getMessage())->push();
        }
    }

    public function render()
    {
        return view('livewire.user.dashboard.home')->layout('layouts.user-base');
    }
}
