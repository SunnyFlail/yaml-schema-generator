<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for number valued properties - declares the min and max values of a number.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Range
{
    public function __construct(
        public int|float|null $minimum = null,
        public int|float|null $maximum = null,
        public int|float|null $exclusiveMinimum = null,
        public int|float|null $exclusiveMaximum = null,
    ) {}
}
