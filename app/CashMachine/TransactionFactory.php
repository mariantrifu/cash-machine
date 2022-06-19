<?php

declare(strict_types=1);

namespace App\CashMachine;

class TransactionFactory
{
    public static function make(string $class, Inputs $data): Transaction
    {
        /**
         * @var Transaction $class
         */
        return new $class($data);
    }
}
