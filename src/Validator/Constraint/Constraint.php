<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Constraint;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\Violation;

interface Constraint
{
    public function supports(Mapping $mapping): bool;

    /**
     * @return iterable<Violation>
     */
    public function validate(Mapping $mapping): iterable;
}
