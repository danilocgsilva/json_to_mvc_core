<?php

declare(strict_types= 1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\JsonToMvc\Exceptions;
use Danilocgsilva\JsonToMvc\JsonToMvc;

class JsonToMvcTest extends TestCase
{
    public JsonToMvc $jsonToMvc;

    public function setUp(): void
    {
        $this->jsonToMvc = new JsonToMvc();
    }

    public function testGetResultsMissingExecution(): void
    {
        $this->expectException(Exceptions\NotExecuted::class);
        $this->jsonToMvc->getResults();
    }

    public function testGetModelTextForPerson(): void
    {
        $expected = <<<'EOT'
        <?php

        declare(strict_types= 1);

        use Illuminate\Database\Eloquent\Model;

        class Person extends Model
        {
            protected $fillable = ['name', 'surname'];
        }
        EOT;

        $sourceJson = <<<'EOT'
        {
            "className": "Person",
            "fields": [
                {
                    "name": "name"
                },
                {
                    "name": "surname"
                }
            ]
        }
        EOT;

        $this->jsonToMvc->setJsonText($sourceJson);
        $this->jsonToMvc->execute();
        $results = $this->jsonToMvc->getResults();

        $this->assertSame($expected, $results->getClassText());
    }

    public function testGetModelTextForCar(): void
    {
        $expected = <<<'EOT'
        <?php

        declare(strict_types= 1);

        use Illuminate\Database\Eloquent\Model;

        class Car extends Model
        {
            protected $fillable = ['brand', 'model'];
        }
        EOT;

        $sourceJson = <<<'EOT'
        {
            "className": "Car",
            "fields": [
                {
                    "name": "brand"
                },
                {
                    "name": "model"
                }
            ]
        }
        EOT;

        $this->jsonToMvc->setJsonText($sourceJson);
        $this->jsonToMvc->execute();
        $results = $this->jsonToMvc->getResults();

        $this->assertSame($expected, $results->getClassText());
    }

    public function testGetModelTextWrongFormat(): void
    {
        $this->expectException(Exceptions\JsonConversionError::class);

        $expected = <<<'EOT'
        <?php

        declare(strict_types= 1);

        use Illuminate\Database\Eloquent\Model;

        class Car extends Model
        {
            protected $fillable = ['brand', 'model'];
        }
        EOT;

        $sourceJson = <<<'EOT'
        {
            className: "Car",
            fields: [
                {
                    name: "brand"
                },
                {
                    name: "model"
                }
            ]
        }
        EOT;

        $this->jsonToMvc->setJsonText($sourceJson);
        $this->jsonToMvc->execute();
    }
}