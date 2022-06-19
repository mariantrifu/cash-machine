<?php

namespace App\Card;

use App\Exceptions\InvalidArgumentException;
use DateTime;

class Card
{
    private int $number;

    private DateTime $expiration;

    private string $holder;

    private int $cvv;

    public const CVV_DIGITS = 3;

    public const CARD_STARTS_WITH = 4;

    public function __construct(int $number, DateTime $expiration, string $holder, int $cvv)
    {
        $invalidArgumentException = $this->validate($number, $expiration, $holder, $cvv);
        if ($invalidArgumentException->numberOfMessages() > 0) {
            throw $invalidArgumentException;
        }

        $this->number = $number;
        $this->expiration = $expiration;
        $this->holder = $holder;
        $this->cvv = $cvv;
    }

    private function luhnChecksum(int $card): bool
    {
        $digits = $this->digitsOf($card);
        $oddDigits = array_filter(
            $digits,
            function ($key) {
                return ($key % 2) != 0;
            },
            ARRAY_FILTER_USE_KEY
        );
        $evenDigits = array_filter(
            $digits,
            function ($key) {
                return ($key % 2) == 0;
            },
            ARRAY_FILTER_USE_KEY
        );
        $total = array_sum($oddDigits);
        foreach ($evenDigits as $digit) {
            $total += array_sum($this->digitsOf(2 * (int) $digit));
        }
        return ($total % 10) == 0;
    }

    /**
     * @return array<array-key, string>
     */
    private function digitsOf(int $number): array
    {
        return str_split((string) $number);
    }

    private function isValidDate(DateTime $dateValue): bool
    {
        $date = strtotime($dateValue->format('y-m-01'));
        $today2Months = strtotime(date('y-m-01', strtotime('+2 months')));

        return $date >= $today2Months;
    }

    private function cardStartsWith(int $number): bool
    {
        $digits = $this->digitsOf($number);
        $first = (int) array_shift($digits);
        return $first === self::CARD_STARTS_WITH;
    }

    private function validate(int $number, DateTime $expiration, string $holder, int $cvv): InvalidArgumentException
    {
        $invalidArgumentException = new InvalidArgumentException();
        if ($this->luhnChecksum($number) === false || $this->cardStartsWith($number) === false) {
            $invalidArgumentException->addMessage(
                key: 'card_number',
                message: 'Invalid Card number.'
            );
        }

        if ($this->isValidDate($expiration) === false) {
            $invalidArgumentException->addMessage(
                key: 'card_date',
                message: 'Invalid card expiration date.'
            );
        }

        if (strlen((string)$cvv) !== self::CVV_DIGITS) {
            $invalidArgumentException->addMessage(
                key: 'card_cvv',
                message: 'Invalid CVV format.'
            );
        }

        return $invalidArgumentException;
    }

    /**
     * @return array<string, DateTime|int|string>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'holder' => $this->holder,
            'expiration' => $this->expiration,
            'cvv' => $this->cvv
        ];
    }
}
