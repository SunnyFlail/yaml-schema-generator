<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class RequiredKeyType
{
    public function __construct(
        public KeyType $type
    ) {}
}
