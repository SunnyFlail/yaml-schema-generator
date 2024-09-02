<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoaderInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\TypeMetaPropertyLoaderInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader\TypeReaderInterface;

final readonly class PrimitiveTypeMappingParser implements TypeMappingParserStrategy
{
    public function __construct(
        private TypeReaderInterface $typeReader,
        private MetaPropertyLoaderInterface $metaPropertyLoader,
        private TypeMetaPropertyLoaderInterface $typeMetaPropertyLoader
    ) {}

    public function supports(Type $type): bool
    {
        return Type::BOOLEAN === $type
            || Type::NUMBER === $type
            || Type::STRING === $type
            || Type::NULL === $type
        ;
    }

    public function parse(\ReflectionProperty $property, Type $type, string $typeString): Mapping
    {
        $builder = new MappingBuilder();
        $builder->type = [$type];
        $this->metaPropertyLoader->load($builder, $property);
        $this->typeMetaPropertyLoader->loadMetaProperties(
            $builder,
            $property,
            $type,
            $typeString
        );

        return $builder->create();
    }
}
