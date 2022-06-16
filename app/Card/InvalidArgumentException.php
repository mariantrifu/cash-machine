<?php

declare(strict_types=1);

namespace App\Card;

use Exception;

class InvalidArgumentException extends Exception
{
    /**
     * @var array<array-key, string> $messages
     */
    private array $messages = [];

    public function addMessage(string $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * @return array<array-key, string>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function numberOfMessages(): int
    {
        return count($this->messages);
    }
}
