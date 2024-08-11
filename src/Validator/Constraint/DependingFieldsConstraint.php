<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

abstract readonly class DependingFieldsConstraint implements Constraint
{
    public function supports(Mapping $mapping): bool
    {
        foreach ($this->getPropertyNames() as $name) {
            if (isset($mapping->$name)) {
                return true;
            }
        }

        return false;
    }

    public function validate(Mapping $mapping): iterable
    {
        if ($this->isRequirementValid($mapping)) {
            return;
        }

        foreach ($this->getPropertyNames() as $name) {
            if (!isset($mapping->$name)) {
                continue;
            }

            yield;
        }
    }

    /**
     * @return iterable<string>
     */
    abstract protected function getPropertyNames(): iterable;

    abstract protected function isRequirementValid(Mapping $mapping): bool;
}
