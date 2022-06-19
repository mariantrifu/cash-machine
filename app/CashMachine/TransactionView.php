<?php

declare(strict_types=1);

namespace App\CashMachine;

class TransactionView
{
    private ?int $id;

    private int $amount;

    /**
     * @var array<array-key, int>
     */
    private array $inputs;

    /**
     * @param array<array-key, int> $inputs
     */
    public function __construct(?int $id, int $amount, array $inputs)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->inputs = $inputs;
    }

    /**
     * @return array<string, array<int>|int|null>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'inputs' => $this->inputs,
        ];
    }
}
