<?php

declare(strict_types=1);

namespace App\CashMachine;

interface Transaction
{
    public function getId(): ?int;

    public function setId(int $id): void;

    public function amount(): int;

    /**
     * @return array<array-key, int>
     */
    public function inputs(): array;

    public function getLimit(): int;
}
