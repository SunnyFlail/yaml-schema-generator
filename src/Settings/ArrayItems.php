<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
final readonly class ArrayItems
{
    /**
     * @var string[]
     */
    public array $allowedTypes;

    public function __construct(
        string ...$allowedTypes
    ) {
        $this->allowedTypes = $allowedTypes;
    }
}
