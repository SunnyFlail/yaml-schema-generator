<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Exception;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Validator\Violation\Violation;

final class ConstraintsFailedException extends \Exception
{
    /**
     * @var Violation[]
     */
    public readonly array $violations;

    public function __construct(
        public readonly Mapping $mapping,
        Violation ...$violations
    ) {
        $this->violations = $violations;

        parent::__construct('Constraints failed for mapping');
    }
}
