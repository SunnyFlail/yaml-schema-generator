<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty;

use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Settings\SettingsAttribute;

final readonly class MetaPropertyLoader implements MetaPropertyLoaderInterface
{
    public function load(
        MappingBuilder $builder,
        \ReflectionProperty|\ReflectionClass $reflection
    ): void {
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
}
