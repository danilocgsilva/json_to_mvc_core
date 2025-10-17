<?php

declare(strict_types= 1);

namespace Danilocgsilva\JsonToMvc;

use Danilocgsilva\JsonToMvc\Exceptions;

class JsonToMvc
{
    private string $jsonText;

    public function setJsonText(string $jsonText): self
    {
        return $this;
    }

    public function getModelText(): string
    {
        if ($this->jsonText === null) {
            throw new Exceptions\JsonNotSetted();
        }

        return "";
    }
}
