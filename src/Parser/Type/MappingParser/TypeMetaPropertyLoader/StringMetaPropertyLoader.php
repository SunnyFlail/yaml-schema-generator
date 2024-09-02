<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Settings\Format;
use SunnyFlail\YamlSchemaGenerator\Settings\Length;
use SunnyFlail\YamlSchemaGenerator\Settings\Pattern;

final readonly class StringMetaPropertyLoader implements TypeMetaPropertyLoaderStrategy
{
    use LoadMultiplePropertiesTrait;

    public function supports(Type $type, string $typeString): bool
    {
        return Type::STRING === $type;
    }

    public function loadMetaProperties(MappingBuilder $builder, \ReflectionProperty $property, Type $type, string $typeString): void
    {
        $this->loadMultipleAttributes(
            $builder,
            $property,
            Length::class,
            Format::class,
            Pattern::class,
        );
    }
}
