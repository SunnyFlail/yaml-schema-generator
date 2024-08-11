<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Runner;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Exception\ConstraintsFailedException;

interface ConstraintRunnerInterface
{
    /**
     * @throws ConstraintsFailedException
     */
    public function run(Mapping $mapping): void;
}
