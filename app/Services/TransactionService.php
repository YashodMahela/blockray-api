<?php

namespace App\Services;
use App\Models\Transaction;
use App\Jobs\ProcessTransactionJob;

class TransactionService
{
    public function getUserTransactions($userId)
    {
        return Transaction::where('user_id',$userId)->orderBy('created_at','desc')->paginate(10);
    }

    public function createTransaction($userId, array $data)
    {
        $data['user_id'] = $userId;
        $data['tx_hash'] = 'tx_' . bin2hex(random_bytes(8));
        $transaction = Transaction::create($data);

        ProcessTransactionJob::dispatch($transaction); // Async job
        return $transaction;
    }
}
