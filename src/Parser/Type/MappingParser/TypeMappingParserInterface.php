<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

interface TypeMappingParserInterface
{
    public function parse(
        \ReflectionProperty $property,
        Type $type,
        string $typeString
    ): Mapping;
}
