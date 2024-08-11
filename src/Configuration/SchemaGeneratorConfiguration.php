<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Configuration;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

final readonly class SchemaGeneratorConfiguration
{
    public function __construct(
        public array $defaultPropertiesValues = []
    ) {
        self::validateProperties($defaultPropertiesValues);
    }

    private static function validateProperties(array $properties): void
    {
        $reflection = new \ReflectionClass(Mapping::class);

        foreach ($properties as $name => $value) {
            if (!$reflection->hasProperty($name)) {
                throw new \LogicException(sprintf('Unknown property %s', $name));
            }
        }
    }
}
