<?php

declare(strict_types=1);

namespace App\CashMachine;

use stdClass;

class TransactionFactory
{
    /**
     * @param array<string, stdClass> $data
     */
    public static function make(string $class,array $data): Transaction
    {
        return new $class($data);
    }
}
