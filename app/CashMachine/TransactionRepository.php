<?php

namespace App\CashMachine;

interface TransactionRepository
{
    public function save(Transaction $transaction): Transaction;

    public function getTotalByTransaction(Transaction $transaction): int;
}
