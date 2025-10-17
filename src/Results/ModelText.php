<?php

declare(strict_types=1);

namespace Danilocgsilva\JsonToMvc\Results;

class ModelText
{
    private array $errors;

    private string $classString;

    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    public function setClassString(string $classString): void
    {
        $this->classString = $classString;
    }

    public function getClassText(): string
    {
        return $this->classString;
    }
}
