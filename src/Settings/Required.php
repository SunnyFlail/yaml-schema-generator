<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Overrides resolved optionality of a property
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Required
{
    public function __construct(
        public bool $required = true
    ) {}
}
