<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class MultipleOf
{
    public function __construct(
        public int|float $multipleOf
    ) {}
}
