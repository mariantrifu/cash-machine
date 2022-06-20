<?php

declare(strict_types=1);

namespace Unit\CashMachine;

use App\CashMachine\Inputs;
use Tests\TestCase;

class InputsTest extends TestCase
{
    public function testItShouldContainArrayOfData(): void
    {
        $inputs = new Inputs([]);

        $this->assertIsArray($inputs->getData());
    }
}
