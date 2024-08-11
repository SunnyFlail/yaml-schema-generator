<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Range
{
    public function __construct(
        public ?int $minimum = null,
        public ?int $maximum = null,
    ) {}
}
