<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\RequiredFieldNotConfiguredViolation;

abstract readonly class RequiredSubpropertyPropertyConstraint implements Constraint
{
    public function supports(Mapping $mapping): bool
    {
        $property = $this->getPropertyName();

        return isset($mapping->$property);
    }

    public function validate(Mapping $mapping): iterable
    {
        $property = $this->getPropertyName();
        $property = $mapping->$property;

        foreach ($this->getRequiredPropertyNames() as $name) {
            if (!isset($property->$name)) {
                yield new RequiredFieldNotConfiguredViolation(
                    $name,
                    $property
                );
            }
        }
    }

    abstract protected function getPropertyName(): string;

    /**
     * @return iterable<string>
     */
    abstract protected function getRequiredPropertyNames(): iterable;
}
