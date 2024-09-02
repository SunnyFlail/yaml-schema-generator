<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;

interface TypeMetaPropertyLoaderInterface
{
    public function loadMetaProperties(
        MappingBuilder $builder,
        \ReflectionProperty $property,
        Type $type,
        string $typeString
    ): void;
}
