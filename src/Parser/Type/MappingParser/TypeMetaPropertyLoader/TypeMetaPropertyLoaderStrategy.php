<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

interface TypeMetaPropertyLoaderStrategy extends TypeMetaPropertyLoaderInterface
{
    public function supports(Type $type, string $typeString): bool;
}
