<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoaderInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyOptionalityResolver\PropertyOptionalityResolverInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser\PropertyParserInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader\TypeReaderInterface;
use SunnyFlail\YamlSchemaGenerator\Settings\Exclude;

final readonly class ClassParser implements ClassParserInterface
{
    public function __construct(
        private TypeReaderInterface $typeReader,
        private PropertyParserInterface $propertyParser,
        private MetaPropertyLoaderInterface $metaPropertyLoader,
        private PropertyOptionalityResolverInterface $propertyOptionalityResolver
    ) {}

    public function parseClass(string $class): Mapping
    {
        $builder = new MappingBuilder();
        $reflection = new \ReflectionClass($class);
        $builder->type = [Type::OBJECT];
        $this->setPropertiesProperty($builder, $reflection);
        $this->metaPropertyLoader->load($builder, $reflection);

        return $builder->create();
    }

    private function setPropertiesProperty(
        MappingBuilder $builder,
        \ReflectionClass $reflection
    ): void {
        $properties = [];
        $required = [];

        foreach ($reflection->getProperties() as $property) {
            if ($property->getAttributes(Exclude::class)) {
                continue;
            }

            $properties[$property->getName()] = $this->getPropertyMapping($property);

            if ($this->propertyOptionalityResolver->isPropertyRequired($property)) {
                $required[] = $property->getName();
            }
        }

        $builder->properties = $properties;

        if ($required) {
            $builder->required = $required;
        }
    }

    private function getPropertyMapping(\ReflectionProperty $property): Mapping
    {
        return $this->propertyParser->parse(
            $property,
            ...$this->typeReader->toStrings($property->getType())
        );
    }
}
