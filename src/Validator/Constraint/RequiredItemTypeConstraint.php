<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Attribute\RequiredItemType;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\WrongItemTypeViolation;

final readonly class RequiredItemTypeConstraint implements Constraint
{
    public function supports(Mapping $mapping): bool
    {
        return true;
    }

    public function validate(Mapping $mapping): iterable
    {
        $reflection = new \ReflectionClass($mapping::class);

        foreach ($reflection->getProperties() as $property) {
            $types = $property->getAttributes(RequiredItemType::class);

            if (!$types || !$property->isInitialized($mapping)) {
                continue;
            }

            yield from $this->validateArrayType(
                $mapping,
                $property,
                ...$types
            );
        }
    }

    /**
     * @param \ReflectionAttribute<RequiredItemType> $types
     */
    private function validateArrayType(
        Mapping $mapping,
        \ReflectionProperty $property,
        \ReflectionAttribute ...$types
    ): iterable {
        $wrongTypesCount = 0;

        foreach ($types as $type) {
            $type = $type->newInstance();

            if (!is_a($property->getValue($mapping), $type->type)) {
                ++$wrongTypesCount;
            }
        }

        if ($wrongTypesCount === count($types)) {
            yield new WrongItemTypeViolation($property->getName(), $type->type);
        }
    }
}
