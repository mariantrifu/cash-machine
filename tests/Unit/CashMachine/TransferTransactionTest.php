<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\Inputs;
use App\CashMachine\Transaction;
use App\CashMachine\TransferTransaction;
use App\Transfer\BankTransfer;
use Tests\TestCase;

class TransferTransactionTest extends TestCase
{
    public function testItShouldBeInstanceOfTransaction(): void
    {
        $data = [
            'amount' => 10,
            'inputs' => $this->createMock(BankTransfer::class),
        ];
        $inputs = $this->createMock(Inputs::class);
        $inputs->expects($this->exactly(2))
            ->method('getData')
            ->willReturn($data);
        $transferTransaction = new TransferTransaction($inputs);
        $transferTransaction->setId(5);

        $this->assertInstanceOf(Transaction::class, $transferTransaction);
        $this->assertIsInt($transferTransaction->getId());
        $this->assertIsInt($transferTransaction->getLimit());
        $this->assertIsInt($transferTransaction->amount());
        $this->assertIsArray($transferTransaction->inputs());
    }
}
