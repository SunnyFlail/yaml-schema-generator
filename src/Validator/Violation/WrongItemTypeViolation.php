<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Violation;

final readonly class WrongItemTypeViolation implements Violation
{
    /**
     * @var string[]
     */
    public array $requiredTypes;

    public function __construct(
        public string $propertyName,
        string ...$requiredTypes,
    ) {
        $this->requiredTypes = $requiredTypes;
    }

    public function getMessage(): string
    {
        return sprintf(
            'Wrong type for %s, %s%s expected',
            $this->propertyName,
            0 === count($this->requiredTypes) ? '' : 'one of ',
            implode(' or ', $this->requiredTypes)
        );
    }
}
