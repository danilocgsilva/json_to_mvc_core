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
            protected $fillable = [%s];
        }
        EOF;

        $dynamicPlaceholders = array_fill(0, count($jsonData->fields), '\'%s\'');

        $dynamicBaseString = sprintf($baseString, $jsonData->className, implode(', ', $dynamicPlaceholders));

        $parameters = array_merge(
            [$dynamicBaseString], 
            array_map(function ($entry) {
                return $entry->name;
            }, $jsonData->fields)
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
