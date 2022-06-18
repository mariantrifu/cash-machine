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
        $total = $this->transactionRepository->getTotalByTransaction($transaction);
        $total += $transaction->amount();

        if ($total > $transaction->getLimit()) {
            $exception = new TransactionAmountExceededException();
            $exception->addMessage(
                'others',
                sprintf(
                    'You can not transact more than %d',
                    $transaction->getLimit()
                ),
            );

            throw $exception;
        }

        $this->transactionRepository->save($transaction);
    }
}
