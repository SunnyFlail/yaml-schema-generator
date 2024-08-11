<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class ArrayTypeConstraint extends TypeRequiresFieldsConstraint
{
    protected function getRequiredType(): Type
    {
        return Type::ARRAY;
    }

    protected function getRequiredFields(): iterable
    {
        yield 'items';
    }
}
