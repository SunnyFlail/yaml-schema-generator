<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Attribute\KeyType;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\Violation;

final readonly class ArrayKeyTypeConstraint extends ArrayPropertyConstraint
{
    protected function passesConstraint(Mapping $mapping, string $propertyName, array $value): bool
    {
        $requiredType = (new \ReflectionClass($mapping))
            ->getProperty($propertyName)
            ->getAttributes()[0] ?? null
        ;

        if (!$requiredType) {
            return true;
        }

        $requiredType = $requiredType->newInstance()->type;

        return match ($requiredType) {
            KeyType::NUMBER => array_is_list($value),
            KeyType::STRING => !array_is_list($value),
        };
    }

    protected function buildViolation(Mapping $mapping, string $propertyName, array $value): Violation
    {
        return null;
    }
}
