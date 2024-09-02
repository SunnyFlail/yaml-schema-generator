<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;

trait LoadMultiplePropertiesTrait
{
    private function loadMultipleAttributes(
        MappingBuilder $builder,
        \ReflectionProperty $property,
        string ...$attributes
    ): void {
        foreach ($attributes as $attribute) {
            $attribute = $property->getAttributes($attribute);

            if ($attribute) {
                $this->loadMultipleProperties($builder, $attribute[0]->newInstance());
            }
        }
    }

    private function loadMultipleProperties(
        MappingBuilder $builder,
        object $attribute
    ): void {
        foreach (get_object_vars($attribute) as $name => $value) {
            if (null !== $value) {
                $builder->$name = $value;
                $builder->isComplexType = true;
            }
        }
    }
}
