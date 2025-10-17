<?php

declare(strict_types= 1);

namespace Danilocgsilva\JsonToMvc;

use Danilocgsilva\JsonToMvc\Results;

class JsonToMvc
{
    private Results\ModelText $results;

    private string $jsonText;

    public function setJsonText(string $jsonText): self
    {
        $this->jsonText = $jsonText;

        return $this;
    }

    public function execute()
    {
        $this->results = new Results\ModelText();

        if (!isset($this->jsonText)) {
            $this->results->addError("");
        }
    }

    public function getResults(): Results\ModelText
    {
        if (!isset($this->results)) {
            throw new Exceptions\NotExecuted();
        }

        return $this->results;
    }
}
