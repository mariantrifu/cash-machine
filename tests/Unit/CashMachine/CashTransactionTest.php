<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\CashTransaction;
use App\CashMachine\Inputs;
use App\CashMachine\Transaction;
use App\Money\BankNote;
use App\Money\BankNoteList;
use App\Money\Money;
use Tests\TestCase;

class CashTransactionTest extends TestCase
{
    public function testItShouldBeInstanceOfTransaction(): void
    {
        $bankNoteList = $this->createMock(BankNoteList::class);
        $bankNote = $this->createMock(BankNote::class);
        $money = $this->createMock(Money::class);
        $money->expects($this->exactly(2))
            ->method('getAmount')
            ->willReturn(10);
        $bankNote->expects($this->exactly(2))
            ->method('getMoney')
            ->willReturn($money);
        $bankNotes = [
            $bankNote,
            $bankNote
        ];
        $bankNoteList->expects($this->once())
            ->method('getBanknotes')
            ->willReturn($bankNotes);
        $data = [
            'banknotes' => $bankNoteList,
        ];
        $inputs = $this->createMock(Inputs::class);
        $inputs->expects($this->once())
            ->method('getData')
            ->willReturn($data);
        $cashTransaction = new CashTransaction($inputs);
        $cashTransaction->setId(5);

        $this->assertInstanceOf(Transaction::class, $cashTransaction);
        $this->assertIsInt($cashTransaction->getId());
        $this->assertIsInt($cashTransaction->getLimit());
        $this->assertIsInt($cashTransaction->amount());
        $this->assertIsArray($cashTransaction->inputs());
    }
}
