<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\TransactionView;
use Tests\TestCase;

class TransactionViewTest extends TestCase
{
    public function testItShouldReturnAnArray(): void
    {
        $transactionView = new TransactionView(
            id: 5,
            amount: 10,
            inputs: [],
        );

        $this->assertIsArray($transactionView->toArray());
    }
}
