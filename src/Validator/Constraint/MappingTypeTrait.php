<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

trait MappingTypeTrait
{
    protected function isOfType(Mapping $mapping, Type $type): bool
    {
        return $mapping->type === $type || (
            is_array($mapping->type) && in_array($type, $mapping->type)
        );
    }
}
