<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Violation;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

final readonly class RequiredFieldNotConfiguredViolation implements Violation
{
    public function __construct(
        public string $field,
        public Mapping $mapping
    ) {}

    public function getMessage(): string
    {
        return sprintf('Required field %s not configured', $this->field);
    }
}
