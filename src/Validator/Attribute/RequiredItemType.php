<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Attribute;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
final readonly class RequiredItemType
{
    public function __construct(
        public string $type
    ) {}
}
