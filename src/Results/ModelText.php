<?php

declare(strict_types=1);

namespace Danilocgsilva\JsonToMvc\Results;

class ModelText
{
    private array $errors;

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }
}
