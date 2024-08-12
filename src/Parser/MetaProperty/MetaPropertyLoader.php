<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty;

use SunnyFlail\YamlSchemaGenerator\Dev\StaticProperty;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMappingParserInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver\TypeResolverInterface;
use SunnyFlail\YamlSchemaGenerator\Settings\PropertyPattern;
use SunnyFlail\YamlSchemaGenerator\Settings\SettingsAttribute;

final readonly class MetaPropertyLoader implements MetaPropertyLoaderInterface
{
    public function __construct(
        private TypeResolverInterface $typeResolver,
        private TypeMappingParserInterface $typeParser
    ) {}

    public function load(
        MappingBuilder $builder,
        \ReflectionProperty|\ReflectionClass $reflection
    ): void {
        $this->loadAdditionalProperties($builder, $reflection);
        $attributes = $reflection->getAttributes(
            SettingsAttribute::class,
            \ReflectionAttribute::IS_INSTANCEOF
        );

        foreach ($attributes as $attribute) {
            $attribute = $attribute->newInstance();
            [
                'name' => $name,
                'value' => $value
            ] = $attribute->getSettingNameAndValue();

            $builder->$name = $value;

            if (isset($builder->isComplexType) && $builder->isComplexType) {
                $builder->isComplexType = true;
            }
        }
    }

    private function loadAdditionalProperties(
        MappingBuilder $builder,
        \ReflectionProperty|\ReflectionClass $reflection
    ): void {
        $attributes = $reflection->getAttributes(PropertyPattern::class);

        if (!$attributes) {
            return;
        }

        $patterns = [];

        foreach ($attributes as $attribute) {
            $attribute = $attribute->newInstance();
            $patterns[$attribute->pattern] = $this->typeParser->parse(
                new \ReflectionProperty(StaticProperty::class, 'property'),
                $this->typeResolver->resolveType($attribute->type),
                $attribute->type
            );
        }

        $builder->propertyPattern = $patterns;
    }
}
