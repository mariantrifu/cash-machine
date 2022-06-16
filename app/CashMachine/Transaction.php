<?php

declare(strict_types=1);

namespace App\CashMachine;

interface Transaction
{
    public function amount(): int;

    /**
     * @return array<array-key, string>
     */
    public function inputs(): array;

    public function getLimit(): int;
}
