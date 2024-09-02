<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;

final readonly class EnumMetaPropertyLoader implements TypeMetaPropertyLoaderStrategy
{
    public function supports(Type $type, string $typeString): bool
    {
        return Type::STRING === $type && enum_exists($typeString);
    }

    public function loadMetaProperties(MappingBuilder $builder, \ReflectionProperty $property, Type $type, string $typeString): void
    {
        $enum = (new \ReflectionEnum($typeString));
        $allowedValues = [];

        foreach ($enum->getCases() as $case) {
            $allowedValues = $case->getValue();
        }

        $builder->isComplexType = true;
        $builder->enum = $allowedValues;
    }
}
