<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyOptionalityResolver;

interface PropertyOptionalityResolverInterface
{
    public function isPropertyRequired(\ReflectionProperty $property): bool;
}
