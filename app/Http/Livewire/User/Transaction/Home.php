<?php

namespace App\Http\Livewire\User\Transaction;

use App\Http\Livewire\BaseComponent;
use AppHelper;
use Paystack;
use App\Repositories\TransactionRepository;

class Home extends BaseComponent
{
    public $status, $remark;

    public function mount()
    {
        $this->fill([
            'status' => request()->has('status') ? request('status') : 'all',
            'remark' => request()->has('remark') ? request('remark') : null
        ]);

        try {
            $paymentDetails = Paystack::getPaymentData();

            if ($paymentDetails['status']) {

                $data = $paymentDetails['data'];

                $transaction = TransactionRepository::getByTrxId($data['reference']);

                if (in_array($transaction->status, ['completed'])) return;

                if ($data['status'] === "success") {

                    $transaction->update([
                        'status' => 'completed'
                    ]);
                } else {

                    $transaction->update([
                        'status' => 'failed'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function render()
    {
        return view('livewire.user.transaction.home')->layout('layouts.user-base');
    }
}
