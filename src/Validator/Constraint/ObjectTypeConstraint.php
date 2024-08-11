<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class ObjectTypeConstraint extends TypeRequiresFieldsConstraint
{
    protected function getRequiredType(): Type
    {
        return Type::OBJECT;
    }

    protected function getRequiredFields(): iterable
    {
        return [];
        // yield 'properties';
        // yield 'additionalProperties';
        // yield 'patternProperties';
    }
}
