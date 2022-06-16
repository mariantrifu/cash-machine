<?php

namespace App\Card;

use DateTime;

class Card
{
    private int $number;

    private DateTime $expiration;

    private string $holder;

    private int $cvv;

    public const CVV_DIGITS = 3;

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
        $odd_digits = array_filter($digits, function($k){
            return ($k%2) != 0;
        }, ARRAY_FILTER_USE_KEY);
        $even_digits = array_filter($digits, function($k){
            return ($k%2) == 0;
        }, ARRAY_FILTER_USE_KEY);
        $total = array_sum($odd_digits);
        foreach($even_digits as $digit){
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
        $today = strtotime(date('y-m-01'));

        return $date >= $today;
    }

    private function validate(int $number, DateTime $expiration, string $holder, int $cvv): InvalidArgumentException
    {
        $invalidArgumentException = new InvalidArgumentException();
        if ($this->luhnChecksum($number) === false) {
            $invalidArgumentException->addMessage('Invalid Card number.');
        }

        if ($this->isValidDate($expiration) === false) {
            $invalidArgumentException->addMessage('Card expired.');
        }

        if (strlen((string)$cvv) !== self::CVV_DIGITS) {
            $invalidArgumentException->addMessage('Invalid CVV format.');
        }

        return $invalidArgumentException;
    }
}
