<?php

declare(strict_types=1);

namespace App\Money;

class BankNote
{
    public Money $money;
    public const ALLOWED_VALUES = [1, 5, 10, 50, 100];

    public function __construct(Money $money)
    {
        if (false === in_array($money->getAmount(),self::ALLOWED_VALUES)) {
            throw new \InvalidArgumentException('Invalid amount to create a bank note');
        }
        $this->money = $money;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }
}
