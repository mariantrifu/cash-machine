<?php

declare(strict_types=1);

namespace App\Repository\Transaction;

use App\CashMachine\CardTransaction;
use App\CashMachine\CashTransaction;
use App\CashMachine\Transaction;
use App\CashMachine\TransactionRepository as TransactionRepositoryAlias;
use App\CashMachine\TransferTransaction;
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

    public function save(Transaction $transaction): Transaction
    {
        $type = $this->getTypeByTransaction($transaction);

        $transactionData = [
            'type' => $type,
            'amount' => $transaction->amount(),
            'inputs' => json_encode($transaction->inputs()),
        ];
        $eloquentTransaction = $this->eloquentTransaction->create($transactionData);
        $transaction->setId($eloquentTransaction->id);
        return $transaction;
    }

    public function getTotalByTransaction(Transaction $transaction): int
    {
        $type = $this->getTypeByTransaction($transaction);

        $eloquentTransaction = $this
            ->eloquentTransaction
            ->where('type', $type)
            ->get();

        $total = 0;

        foreach ($eloquentTransaction as $transaction) {
            $total += $transaction->amount;
        }

        return $total;
    }

    private function getTypeByTransaction(Transaction $transaction): string
    {
        return match (get_class($transaction)) {
            CashTransaction::class => 'cash',
            CardTransaction::class => 'card',
            TransferTransaction::class => 'transfer',
        };
    }
}
