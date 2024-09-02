<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for array properties - declares the min and max length of the array.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class ItemsCount
{
    public function __construct(
        public ?int $minItems = null,
        public ?int $maxItems = null,
    ) {}
}
