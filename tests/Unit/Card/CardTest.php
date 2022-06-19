<?php

declare(strict_types=1);

namespace Unit\Card;

use App\Card\Card;
use App\Exceptions\InvalidArgumentException;
use Tests\TestCase;

class CardTest extends TestCase
{
    public function testItShouldBeAValidCard(): void
    {
        $date = new \DateTime('now');
        $date->add(new \DateInterval('P3M'));
        $card = new Card(
            number: 4532782477911517,
            expiration: $date,
            holder: 'Marian',
            cvv: 123,
        );

        $this->assertIsArray($card->toArray());
    }

    public function testItShouldThrowInvalidArgumentException(): void
    {
        $date = new \DateTime('now');
        $date->add(new \DateInterval('P1M'));

        $this->expectException(InvalidArgumentException::class);

        new Card(
            number: 45327824779115171,
            expiration: $date,
            holder: 'Marian',
            cvv: 12,
        );
    }
}
