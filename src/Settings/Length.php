<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

/**
 * Only for string valued properties - declares the min and max length of a string.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Length
{
    public function __construct(
        public ?int $minLength = null,
        public ?int $maxLength = null,
    ) {}
}
