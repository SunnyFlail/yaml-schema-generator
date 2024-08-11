<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty;

use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;

interface MetaPropertyLoaderInterface
{
    public function load(
        MappingBuilder $builder,
        \ReflectionProperty|\ReflectionClass $reflection
    ): void;
}
