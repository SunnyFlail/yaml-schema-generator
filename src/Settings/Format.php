<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for string type properties - defines the required value format.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Format
{
    public function __construct(
        public Formats $format
    ) {}
}
