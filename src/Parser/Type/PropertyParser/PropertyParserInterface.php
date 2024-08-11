<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

interface PropertyParserInterface
{
    public function parse(
        \ReflectionProperty $property,
        string ...$typeStrings
    ): Mapping;
}
