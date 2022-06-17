<?php

declare(strict_types=1);

namespace App\CashMachine;

use App\Money\BankNoteList;

class CashTransaction implements Transaction
{
    private BankNoteList $bankNotes;

    public const NUMBER_OF_BANKNOTES = 5;

    /**
     * @param array<string, BankNoteList> $data
     */
    public function __construct(array $data)
    {
        $this->bankNotes = $data['banknotes'];
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
}
