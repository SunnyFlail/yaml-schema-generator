<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMetaPropertyLoader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;

final readonly class TypeMetaPropertyLoaderAggregate implements TypeMetaPropertyLoaderInterface
{
    /**
     * @var TypeMetaPropertyLoaderStrategy[]
     */
    public array $strategies;

    public function __construct(
        TypeMetaPropertyLoaderStrategy ...$strategies
    ) {
        $this->strategies = $strategies;
    }

    public function loadMetaProperties(
        MappingBuilder $builder,
        \ReflectionProperty $property,
        Type $type,
        string $typeString
    ): void {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type, $typeString)) {
                $strategy->loadMetaProperties(
                    $builder,
                    $property,
                    $type,
                    $typeString
                );
            }
        }
    }
}
