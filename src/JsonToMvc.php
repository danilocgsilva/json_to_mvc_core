<?php

declare(strict_types= 1);

namespace Danilocgsilva\JsonToMvc;

use Danilocgsilva\JsonToMvc\Results;

class JsonToMvc
{
    private Results\ModelText $results;

    private string $namespace;

    private string $jsonText;

    public function setJsonText(string $jsonText): self
    {
        $this->jsonText = $jsonText;

        return $this;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function execute(): void
    {
        $this->results = new Results\ModelText();

        if (!isset($this->jsonText)) {
            $this->results->addError("");
        }

        $convertter = new ConvertJsonTextToModelText(
            $this->jsonText
        );

        $this->results->setClassString($convertter->getString());
    }

    public function getResults(): Results\ModelText
    {
        if (!isset($this->results)) {
            throw new Exceptions\NotExecuted();
        }

        return $this->results;
    }
}
