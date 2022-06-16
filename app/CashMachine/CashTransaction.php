<?php

declare(strict_types=1);

namespace App\CashMachine;

use App\Money\BankNote;
use App\Money\BankNoteList;

class CashTransaction implements Transaction
{
    private BankNoteList $bankNotes;

    public const NUMBER_OF_BANKNOTES = 5;

    /**
     * @param BankNoteList $bankNotes
     */
    public function __construct(BankNoteList $bankNotes)
    {
        $this->bankNotes = $bankNotes;
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
