<?php

declare(strict_types=1);

namespace App\CashMachine;

use DateTime;
use App\Transfer\BankTransfer;

class TransferTransaction implements Transaction
{
    private ?int $id;

    private int $amount;

    private BankTransfer $inputs;

    public function __construct(Inputs $inputs)
    {
        $this->amount = $inputs->getData()['amount'];
        $this->inputs = $inputs->getData()['inputs'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return array<array-key, DateTime|string|int>
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
