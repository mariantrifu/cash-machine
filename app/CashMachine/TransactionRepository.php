<?php

namespace App\CashMachine;

interface TransactionRepository
{
    public function save(Transaction $transaction): void;
}
