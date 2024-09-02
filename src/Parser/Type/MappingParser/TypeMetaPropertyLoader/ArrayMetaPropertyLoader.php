<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Settings\Contains;
use SunnyFlail\YamlSchemaGenerator\Settings\ItemsCount;

final readonly class ArrayMetaPropertyLoader implements TypeMetaPropertyLoaderStrategy
{
    use LoadMultiplePropertiesTrait;

    public function supports(Type $type, string $typeString): bool
    {
        return Type::ARRAY === $type;
    }

    public function loadMetaProperties(MappingBuilder $builder, \ReflectionProperty $property, Type $type, string $typeString): void
    {
        $this->loadMultipleAttributes(
            $builder,
            $property,
            ItemsCount::class,
            Contains::class,
        );
    }
}
