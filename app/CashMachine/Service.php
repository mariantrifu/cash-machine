<?php

declare(strict_types=1);

namespace App\CashMachine;

class Service
{
    public function __construct(
        private TransactionRepository $transactionRepository
    ) {
    }

    public function store(Transaction $transaction): void
    {
        $this->transactionRepository->save($transaction);
    }
}
