<?php

declare(strict_types=1);

namespace App\Money;

class Card
{
    public int $number;

    public \DateTime $expiration;

    public string $holder;

    public int $cvv;

    public function __construct(int $number, \DateTime $expiration, string $holder, int $cvv)
    {
        $this->number = $number;
        $this->expiration = $expiration;
        $this->holder = $holder;
        $this->cvv = $cvv;
    }
}
