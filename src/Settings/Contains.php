<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for array properties.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Contains
{
    public function __construct(
        public ?int $minContains = null,
        public ?int $maxContains = null,
    ) {}
}
