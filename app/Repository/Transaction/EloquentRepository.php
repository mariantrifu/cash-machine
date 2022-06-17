<?php

declare(strict_types=1);

namespace App\Repository\Transaction;

use App\CashMachine\Transaction;
use App\CashMachine\TransactionRepository as TransactionRepositoryAlias;
use App\Models\Transaction as EloquentTransaction;

class EloquentRepository implements TransactionRepositoryAlias
{
    private EloquentTransaction $eloquentTransaction;

    /**
     * @param EloquentTransaction $eloquentTransaction
     */
    public function __construct(EloquentTransaction $eloquentTransaction)
    {
        $this->eloquentTransaction = $eloquentTransaction;
    }

    public function save(Transaction $transaction): void
    {
        $transactionData = [
            'amount' => $transaction->amount(),
            'inputs' => json_encode($transaction->inputs()),
        ];
        $this->eloquentTransaction->create($transactionData);
    }


}
