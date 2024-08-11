<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\Violation;

abstract readonly class ArrayPropertyConstraint implements Constraint
{
    public function supports(Mapping $mapping): bool
    {
        return true;
    }

    public function validate(Mapping $mapping): iterable
    {
        foreach (get_object_vars($mapping) as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            if (!$this->passesConstraint($mapping, $key, $value)) {
                yield $this->buildViolation($mapping, $key, $value);
            }
        }
    }

    abstract protected function passesConstraint(Mapping $mapping, string $propertyName, array $value): bool;

    abstract protected function buildViolation(Mapping $mapping, string $propertyName, array $value): Violation;
}
