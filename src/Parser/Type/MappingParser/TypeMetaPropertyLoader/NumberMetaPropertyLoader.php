<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Settings\MultipleOf;
use SunnyFlail\YamlSchemaGenerator\Settings\Range;

final readonly class NumberMetaPropertyLoader implements TypeMetaPropertyLoaderStrategy
{
    use LoadMultiplePropertiesTrait;

    public function supports(Type $type, string $typeString): bool
    {
        return Type::NUMBER === $type;
    }

    public function loadMetaProperties(MappingBuilder $builder, \ReflectionProperty $property, Type $type, string $typeString): void
    {
        $this->loadMultipleAttributes(
            $builder,
            $property,
            Range::class,
            MultipleOf::class,
        );
    }
}
