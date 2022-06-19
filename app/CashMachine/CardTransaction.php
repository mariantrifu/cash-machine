<?php

declare(strict_types=1);

namespace App\CashMachine;

use App\Card\Card;
use DateTime;

class CardTransaction implements Transaction
{
    private ?int $id;

    private int $amount;

    private Card $inputs;

    public function __construct(Inputs $inputsData)
    {
        $this->amount = $inputsData->getData()['amount'];
        $this->inputs = $inputsData->getData()['inputs'];
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
