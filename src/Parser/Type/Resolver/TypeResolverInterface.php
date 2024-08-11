<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

interface TypeResolverInterface
{
    public function resolveType(string $typeString): Type;
}
