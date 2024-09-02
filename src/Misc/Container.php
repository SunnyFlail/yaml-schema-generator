<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Misc;

use SunnyFlail\YamlSchemaGenerator\Parser\ClassParser;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\ArrayTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\ObjectTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\PrimitiveTypeMappingParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMappingParserAggregate;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMappingParserInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\ArrayMetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\EnumMetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\NumberMetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\StringMetaPropertyLoader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader\TypeMetaPropertyLoaderAggregate;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyOptionalityResolver\PropertyOptionalityResolver;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser\PropertyParser;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader\TypeReader;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver\TypeResolver;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver\TypeResolverInterface;

final readonly class Container
{
    public function createClassParser(): ClassParser
    {
        $reflection = new \ReflectionClass(ClassParser::class);
        $typeMappingParser = (new \ReflectionClass(TypeMappingParserAggregate::class))
            ->newInstanceWithoutConstructor()
        ;
        $classParser = $reflection->newInstanceWithoutConstructor();
        $typeReader = $this->createTypeReader();
        $typeResolver = $this->createTypeResolver();
        $metaPropertyLoader = $this->createMetaPropertyLoader(
            $typeResolver,
            $typeMappingParser
        );
        $propertyParser = $this->createPropertyParser(
            $classParser,
            $typeReader,
            $metaPropertyLoader,
            $typeResolver,
            $typeMappingParser
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
        $reflection->getProperty('propertyOptionalityResolver')
            ->setValue($classParser, new PropertyOptionalityResolver())
        ;

        return $classParser;
    }

    private function createTypeReader(): TypeReader
    {
        return new TypeReader();
    }

    private function createMetaPropertyLoader(
        TypeResolverInterface $typeResolver,
        TypeMappingParserInterface $typeMappingParser
    ): MetaPropertyLoader {
        return new MetaPropertyLoader($typeResolver, $typeMappingParser);
    }

    private function createPropertyParser(
        ClassParser $classParser,
        TypeReader $typeReader,
        MetaPropertyLoader $metaPropertyLoader,
        TypeResolverInterface $typeResolver,
        TypeMappingParserAggregate $typeMappingParser
    ): PropertyParser {
        $reflection = new \ReflectionClass(PropertyParser::class);
        $propertyParser = $reflection->newInstanceWithoutConstructor();

        $reflection->getProperty('typeResolver')->setValue(
            $propertyParser,
            $typeResolver
        );
        $reflection->getProperty('typeMappingParser')->setValue(
            $propertyParser,
            $this->configureTypeMappingParser(
                $typeMappingParser,
                $classParser,
                $typeReader,
                $propertyParser,
                $metaPropertyLoader,
            )
        );

        return $propertyParser;
    }

    private function createTypeResolver(): TypeResolver
    {
        return new TypeResolver();
    }

    private function configureTypeMappingParser(
        TypeMappingParserAggregate $typeMappingParser,
        ClassParser $classParser,
        TypeReader $typeReader,
        PropertyParser $propertyParser,
        MetaPropertyLoader $metaPropertyLoader
    ): TypeMappingParserAggregate {
        $reflection = new \ReflectionClass(TypeMappingParserAggregate::class);

        $typeMetaPropertyLoader = new TypeMetaPropertyLoaderAggregate(
            new NumberMetaPropertyLoader(),
            new ArrayMetaPropertyLoader(),
            new EnumMetaPropertyLoader(),
            new StringMetaPropertyLoader(),
        );

        $strategies = [
            new PrimitiveTypeMappingParser(
                $typeReader,
                $metaPropertyLoader,
                $typeMetaPropertyLoader
            ),
            new ArrayTypeMappingParser(
                $propertyParser,
                $metaPropertyLoader,
                $typeMetaPropertyLoader
            ),
            new ObjectTypeMappingParser($classParser),
        ];

        $reflection->getProperty('strategies')->setValue($typeMappingParser, $strategies);

        return $typeMappingParser;
    }
}
