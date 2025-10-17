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

    public function testGetModelText(): void
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

        $this->markTestIncomplete();
    }
}