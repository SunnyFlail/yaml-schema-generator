<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
final readonly class PropertyPattern
{
    public function __construct(
        public string $pattern,
        public string $type
    ) {}
}
