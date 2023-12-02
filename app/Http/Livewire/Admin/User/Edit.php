<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\BaseComponent;
use App\Repositories\UserRepository;
use App\Models\User;
use AppHelper;

class Edit extends BaseComponent
{

    public $mobile_number, $email, $first_name, $last_name;
    public $password, $password_confirmation, $user;

    public function mount($id){
        AppHelper::hasPermissionTo('edit_user');

        $this->user = User::findOrFail($id);

        $this->fill([
            'mobile_number' => $this->user->mobile_number,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email
        ]);
    }


    public function submit(UserRepository $userRepo){

        $this->validate([
            // 'mobile_number' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'nullable|alpha_num|min:6',
            'email' => 'required|unique:users,email,'.$this->user->id,
        ]);


        $data = [
            // 'mobile_number' => $this->mobile_number, 
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password ? bcrypt($this->password) : $this->user->password
        ];

        try {

            throw_unless($userRepo->updateUser($data, $this->user->id), "Failed to update Customer");

            toast()->success('Customer Information updated')->pushOnNextPage();

            return redirect()->route("admin.user.list");

        } catch (\Exception $e) {
            
            return toast()->danger($e->getMessage())->push();   

        }

    }

    public function render()
    {
        return view('livewire.admin.user.edit')->layout('layouts.admin-base');
    }
}
