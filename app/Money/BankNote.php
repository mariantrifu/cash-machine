<?php

declare(strict_types=1);

namespace App\Money;

use App\Exceptions\InvalidArgumentException;
use JsonSerializable;

class BankNote implements JsonSerializable
{
    private Money $money;
    public const ALLOWED_VALUES = [1, 5, 10, 50, 100];

    public function __construct(Money $money)
    {
        if (false === in_array($money->getAmount(), self::ALLOWED_VALUES)) {
             $exception = new InvalidArgumentException();
            $exception->addMessage(
                key: 'money',
                message: sprintf('Invalid amount "%d" to create a bank note', $money->getAmount()),
            );

             throw $exception;
        }
        $this->money = $money;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function jsonSerialize(): string
    {
        return (string) $this->money->getAmount();
    }
}
