<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class ObjectTypeDependingFieldsConstraint extends DependingFieldsConstraint
{
    use MappingTypeTrait;

    protected function getPropertyNames(): iterable
    {
        yield 'properties';
        yield 'additionalProperties';
        yield 'patternProperties';
    }

    protected function isRequirementValid(Mapping $mapping): bool
    {
        return $this->isOfType($mapping, Type::OBJECT);
    }
}
