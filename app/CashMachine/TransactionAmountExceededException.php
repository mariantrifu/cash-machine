<?php

namespace App\CashMachine;

use App\Card\InvalidArgumentException;

class TransactionAmountExceededException extends InvalidArgumentException
{
}
