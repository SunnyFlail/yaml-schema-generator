<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

interface TypeMappingParserStrategy extends TypeMappingParserInterface
{
    public function supports(Type $type): bool;
}
