<?php

declare(strict_types=1);

namespace App\CashMachine;

use App\Card\Card;
use DateTime;

class CardTransaction implements Transaction
{
    private int $amount;

    private Card $inputs;

    /**
     * @param array<string, int> $data
     */
    public function __construct(array $data)
    {
        $this->amount = $data['amount'];
        $this->inputs = $data['inputs'];
    }

    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return array<string, DateTime|int|string>
     */
    public function inputs(): array
    {
        return $this->inputs->toArray();
    }

    public function getLimit(): int
    {
        return 20000;
    }
}
