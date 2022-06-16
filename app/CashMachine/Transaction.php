<?php

declare(strict_types=1);

namespace App\CashMachine;

interface Transaction
{
    public function amount(): float;

    public function inputs(): array;
}
