<?php

namespace Unit\CashMachine;

use App\Card\Card;
use App\CashMachine\CardTransaction;
use App\CashMachine\Inputs;
use App\CashMachine\Transaction;
use Tests\TestCase;

class CardTransactionTest extends TestCase
{
    public function testItShouldOfTypeTransaction(): void
    {
        $data = [
            'amount' => 10,
            'inputs' => $this->createMock(Card::class),
        ];
        $inputs = $this->createMock(Inputs::class);
        $inputs->expects($this->exactly(2))
            ->method('getData')
            ->willReturn($data);
        $cardTransaction = new CardTransaction($inputs);
        $cardTransaction->setId(5);

        $this->assertInstanceOf(Transaction::class, $cardTransaction);
        $this->assertIsArray($cardTransaction->inputs());
        $this->assertIsInt($cardTransaction->getLimit());
        $this->assertIsInt($cardTransaction->getId());
        $this->assertIsInt($cardTransaction->amount());
    }
}
