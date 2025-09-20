<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    protected $service;
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return TransactionResource::collection(
            $this->service->getUserTransactions(auth()->id())
        );
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->service->createTransaction(auth()->id(), $request->validated());
        return new TransactionResource($transaction);
    }
}
