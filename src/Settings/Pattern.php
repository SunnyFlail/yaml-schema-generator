<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for string valued properties - declares the regex which values need to pass.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Pattern
{
    public function __construct(
        public string $pattern
    ) {}
}
