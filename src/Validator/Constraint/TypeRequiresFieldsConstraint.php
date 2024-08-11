<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\RequiredFieldNotConfiguredViolation;

abstract readonly class TypeRequiresFieldsConstraint implements Constraint
{
    use MappingTypeTrait;

    public function supports(Mapping $mapping): bool
    {
        return
            isset($mapping->type)
            && $this->isOfType($mapping, $this->getRequiredType())
        ;
    }

    public function validate(Mapping $mapping): iterable
    {
        foreach ($this->getRequiredFields() as $field) {
            if (!isset($mapping->$field)) {
                yield new RequiredFieldNotConfiguredViolation($field, $mapping);
            }
        }
    }

    abstract protected function getRequiredType(): Type;

    /**
     * @return iterable<string>
     */
    abstract protected function getRequiredFields(): iterable;
}
