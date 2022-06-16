<?php

declare(strict_types=1);

namespace App\Money;

class BankNoteList
{
    /**
     * @var array<array-key, BankNote> $banknotes
     */
    private array $banknotes;

    /**
     * @param array<array-key, BankNote> $banknotes
     */
    public function __construct(array $banknotes)
    {
        $this->banknotes = $banknotes;
    }

    public function add(BankNote $bankNote): void
    {
        $this->banknotes[] = $bankNote;
    }

    /**
     * @return array<array-key, BankNote>
     */
    public function getBanknotes(): array
    {
        return $this->banknotes;
    }

    /**
     * @return array<array-key, string>
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->banknotes as $banknote) {
            $array[] = $banknote->jsonSerialize();
        }
        return $array;
    }
}
