<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Violation;

interface Violation
{
    public function getMessage(): string;
}
