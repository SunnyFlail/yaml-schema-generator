<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoaderInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser\PropertyParserInterface;
use SunnyFlail\YamlSchemaGenerator\Settings\ArrayItems;

final readonly class ArrayTypeMappingParser implements TypeMappingParserStrategy
{
    public function __construct(
        private TypeMappingParserInterface $typeMappingParser,
        private PropertyParserInterface $propertyParser,
        private MetaPropertyLoaderInterface $metaPropertyLoader
    ) {}

    public function supports(Type $type): bool
    {
        return Type::ARRAY === $type;
    }

    public function parse(\ReflectionProperty $property, Type $type, string $typeString): Mapping
    {
        $builder = new MappingBuilder();
        $builder->type = [$type];
        $builder->items = $this->createTypesMapping($property);
        $this->metaPropertyLoader->load($builder, $property);

        return $builder->create();
    }

    private function createTypesMapping(\ReflectionProperty $property): Mapping
    {
        $typeStrings = $this->readArrayItemTypes($property);
        $mapping = $this->propertyParser->parse(
            $property,
            ...$typeStrings
        );

        return $mapping;
    }

    /**
     * @return string[]
     */
    private function readArrayItemTypes(\ReflectionProperty $property): array
    {
        $itemType = $property->getAttributes(ArrayItems::class);

        foreach ($itemType as $type) {
            return $type->newInstance()->allowedTypes;
        }

        throw new \LogicException(sprintf('Type not provided for items of %s::', $property->getDeclaringClass()->getShortName(), $property->getName()));
    }
}
