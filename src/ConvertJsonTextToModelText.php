<?php

declare(strict_types= 1);

namespace Danilocgsilva\JsonToMvc;

use Danilocgsilva\JsonToMvc\Exceptions\JsonConversionError;
use stdClass;

class ConvertJsonTextToModelText
{
    public function __construct(
        private string $jsonText,
    ) {}

    public function getString() : string
    {
        $jsonData = $this->getValues();

        $baseString = <<<'EOF'
        <?php

        declare(strict_types= 1);

        use Illuminate\Database\Eloquent\Model;

        class %s extends Model
        {
            protected $fillable = ['%s', '%s'];
        }
        EOF;

        $parameters = array_merge(
            [$baseString], 
            [
                $jsonData->className, 
                $jsonData->fields[0]->name, 
                $jsonData->fields[1]->name
            ]
        );

        return sprintf(
            ...$parameters
        );
    }

    private function getValues(): stdClass
    {
        $jsonData = json_decode($this->jsonText);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonConversionError(json_last_error_msg());
        }

        return $jsonData;
    }
}
