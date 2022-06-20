<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\CashTransaction;
use App\CashMachine\Inputs;
use App\CashMachine\Transaction;
use App\CashMachine\TransactionFactory;
use App\Money\BankNoteList;
use Tests\TestCase;

class TransactionFactoryTest extends TestCase
{
    public function testItShouldCreateATransaction(): void
    {
        $data = [
            'banknotes' => $this->createMock(BankNoteList::class),
        ];
        $inputs = $this->createMock(Inputs::class);
        $inputs->expects($this->once())
            ->method('getData')
            ->willReturn($data);
        $transaction = TransactionFactory::make(
            class: CashTransaction::class,
            data: $inputs,
        );

        $this->assertInstanceOf(Transaction::class, $transaction);
    }
}
