<?php

namespace App\Repositories;

use App\Models\Transaction;
use DB;
use Carbon\Carbon;

class TransactionRepository
{

    public static function saveTransaction($data)
    {
        //Generate Transaction when ever withdraw has been added to database
        return Transaction::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'trx' => $data['trx'],
            'charge' => $data['charge'],
            'trx_type' => $data['type'],
            'details' => $data['details'],
            'remark' => $data['remark'],
        ]);
    }



    public static function updateTransactionStatus($status, $id): bool
    {
        $transaction = Transaction::findOrFail($id);

        throw_if(in_array($transaction->status, ['cancelled', 'completed']), "You cannot change status of a completed transaction");

        return $transaction->update(['status' => $status]);
    }

    public static function getById(string $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

    public static function getByTrxId(string $trx): Transaction
    {
        return Transaction::where('trx', $trx)->first();
    }

    public static function previousTransaction(string $id)
    {
        return Transaction::where('id', '<', $id)->latest()->first();
    }

    public static function nextTransaction(string $id)
    {
        return Transaction::where('id', '>', $id)->first();
    }
}
