<?php

declare(strict_types=1);

namespace App\Transfer;

use App\Exceptions\InvalidArgumentException;
use DateTime;

class BankTransfer
{
    private string $account;

    private string $customer;

    private DateTime $date;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $account, string $customer, DateTime $date)
    {
        if ($this->isValidDate($date) === false) {
            $exception = new InvalidArgumentException();
            $exception->addMessage(
                key: 'transfer date',
                message: 'Transfer date can not be older than today.',
            );
            throw $exception;
        }
        $this->account = $account;
        $this->customer = $customer;
        $this->date = $date;
    }

    public function toArray(): array
    {
        return [
            'account' => $this->account,
            'customer' => $this->customer,
            'date' => $this->date->format('Y-m-d'),
        ];
    }

    private function isValidDate(DateTime $dateValue): bool
    {
        $date = strtotime($dateValue->format('y-m-01'));
        $today = strtotime(date('y-m-01'));

        return $date >= $today;
    }
}
