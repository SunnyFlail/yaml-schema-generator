<?php

namespace SunnyFlail\YamlSchemaGenerator\Dev;

use SunnyFlail\YamlSchemaGenerator\Parser\ClassParser;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\ArrayTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\ObjectTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\PrimitiveTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMappingParserAggregate;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser\PropertyParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader\TypeReader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver\TypeResolver;

final readonly class Container
{
    public function createClassParser(): ClassParser
    {
        $reflection = new \ReflectionClass(ClassParser::class);
        $classParser = $reflection->newInstanceWithoutConstructor();
        $typeReader = $this->createTypeReader();
        $metaPropertyLoader = $this->createMetaPropertyLoader();
        $propertyParser = $this->createPropertyParser(
            $classParser,
            $typeReader,
            $metaPropertyLoader
        );

        $reflection->getProperty('typeReader')
            ->setValue($classParser, $typeReader)
        ;
        $reflection->getProperty('propertyParser')
            ->setValue($classParser, $propertyParser)
        ;
        $reflection->getProperty('metaPropertyLoader')
            ->setValue($classParser, $metaPropertyLoader)
        ;

        return $classParser;
    }

    private function createTypeReader(): TypeReader
    {
        return new TypeReader();
    }

    private function createMetaPropertyLoader(): MetaPropertyLoader
    {
        return new MetaPropertyLoader();
    }

    private function createPropertyParser(
        ClassParser $classParser,
        TypeReader $typeReader,
        MetaPropertyLoader $metaPropertyLoader
    ): PropertyParser
    {
        $reflection = new \ReflectionClass(PropertyParser::class);
        $propertyParser = $reflection->newInstanceWithoutConstructor();
        
        $reflection->getProperty('typeResolver')->setValue(
            $propertyParser,
            $this->createTypeResolver()
        );
        $reflection->getProperty('typeMappingParser')->setValue(
            $propertyParser,
            $this->createTypeMappingParser(
                $classParser,
                $typeReader,
                $propertyParser,
                $metaPropertyLoader
            )
        );

        return $propertyParser;
    }

    private function createTypeResolver(): TypeResolver
    {
        return new TypeResolver();
    }

    private function createTypeMappingParser(
        ClassParser $classParser,
        TypeReader $typeReader,
        PropertyParser $propertyParser,
        MetaPropertyLoader $metaPropertyLoader
    ): TypeMappingParserAggregate
    {
        $reflection = new \ReflectionClass(TypeMappingParserAggregate::class);
        $typeMappingParser = $reflection->newInstanceWithoutConstructor();

        $strategies = [
            new PrimitiveTypeMappingParser(
                $typeReader,
                $metaPropertyLoader
            ),
            new ArrayTypeMappingParser(
                $typeMappingParser,
                $propertyParser,
                $metaPropertyLoader
            ),
            new ObjectTypeMappingParser($classParser)
        ];

        $reflection->getProperty('strategies')->setValue($typeMappingParser, $strategies);

        return $typeMappingParser;
    }
}
