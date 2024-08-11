<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class ArrayTypeDependingFieldsConstraint extends DependingFieldsConstraint
{
    use MappingTypeTrait;

    protected function getPropertyNames(): iterable
    {
        yield 'uniqueItems';
        yield 'items';
    }

    protected function isRequirementValid(Mapping $mapping): bool
    {
        return $this->isOfType($mapping, Type::ARRAY);
    }
}
