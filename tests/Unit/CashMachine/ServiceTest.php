<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\Service;
use App\CashMachine\Transaction;
use App\CashMachine\TransactionAmountExceededException;
use App\CashMachine\TransactionRepository;
use App\CashMachine\TransactionView;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    public function testItShouldStoreATransaction(): void
    {
        $service = new Service(
            transactionRepository: $this->createMock(TransactionRepository::class),
        );

        $transaction = $this->createMock(Transaction::class);
        $transactionView = $service->store($transaction);

        $this->assertInstanceOf(TransactionView::class, $transactionView);
    }

    public function testItShouldThrowExceptionTransactionAmountExceeded(): void
    {
        $transactionRepo = $this->createMock(TransactionRepository::class);
        $transactionRepo->expects($this->once())
            ->method('getTotalByTransaction')
            ->willReturn(19999);
        $service = new Service(
            transactionRepository: $transactionRepo,
        );

        $transaction = $this->createMock(Transaction::class);
        $transaction->expects($this->once())
            ->method('amount')
            ->willReturn(100);
        $transaction->expects($this->exactly(2))
            ->method('getLimit')
            ->willReturn(20000);

        $this->expectException(TransactionAmountExceededException::class);

        $transactionView = $service->store($transaction);
    }
}
