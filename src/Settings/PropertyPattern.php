<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute()]
final readonly class PropertyPattern
{
    public function __construct(
        public string $pattern,
        public string $type
    ) {}
}
