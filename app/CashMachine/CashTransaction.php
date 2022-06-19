<?php

declare(strict_types=1);

namespace App\CashMachine;

use App\Money\BankNoteList;

class CashTransaction implements Transaction
{
    private ?int $id;

    private BankNoteList $bankNotes;

    public const NUMBER_OF_BANKNOTES = 5;

    public function __construct(Inputs $inputsData)
    {
        $this->bankNotes = $inputsData->getData()['banknotes'];
    }

    public function amount(): int
    {
        $total = 0;
        foreach ($this->bankNotes->getBanknotes() as $bankNote) {
            $total += $bankNote->getMoney()->getAmount();
        }
        return $total;
    }

    public function inputs(): array
    {
        return $this->bankNotes->toArray();
    }

    public function getLimit(): int
    {
        return 10000;
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
