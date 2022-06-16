<?php

declare(strict_types=1);

namespace App\Money;

class Money
{
    private int $amount;

    public const CENTS = 100;

    public function __construct(int $amount)
    {
        $this->amount = $amount * self::CENTS;
    }

    public function getAmount(): int
    {
        return $this->amount / self::CENTS;
    }
}
