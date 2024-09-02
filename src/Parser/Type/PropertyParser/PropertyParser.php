<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser\TypeMappingParserInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver\TypeResolverInterface;

// final readonly class PropertyParser implements PropertyParserInterface
final class PropertyParser implements PropertyParserInterface
{
    public function __construct(
        private TypeResolverInterface $typeResolver,
        private TypeMappingParserInterface $typeMappingParser,
    ) {}
    private bool $debug = false;

    public function parse(
        \ReflectionProperty $property,
        string ...$typeStrings
    ): Mapping {
        $mappings = [];

        foreach ($typeStrings as $typeString) {
            $type = $this->typeResolver->resolveType($typeString);
            $mappings[] = $this->typeMappingParser->parse(
                $property,
                $type,
                $typeString
            );
        }

        if ('arrayOfNumbersOrStrings' === $property->getName() && !in_array('array', $typeStrings)) {
            $this->debug = true;
        }
        if (!$type) {
            throw new NoTypeDefinitionAvailableException($property);
        }

        return $this->createPropertyMapping(...$mappings);
    }

    private function createPropertyMapping(Mapping ...$mappings): Mapping
    {
        if ($this->hasComplexTypes(...$mappings)) {
            return $this->createComplexPropertyMapping(...$mappings);
        }

        return $this->createSimplePropertyMapping(...$mappings);
    }

    private function hasComplexTypes(Mapping ...$mappings): bool
    {
        $objectCount = 0;
        $complexTypeCount = 0;

        foreach ($mappings as $mapping) {
            if (isset($mapping->isComplexType)) {
                ++$complexTypeCount;
            }

            if (Type::OBJECT === $mapping->type) {
                ++$objectCount;
            }
        }

        return $complexTypeCount > 1 || $objectCount > 1;
    }

    private function createComplexPropertyMapping(Mapping ...$mappings): Mapping
    {
        $builder = new MappingBuilder();
        $builder->oneOf = $mappings;

        return $builder->create();
    }

    private function createSimplePropertyMapping(Mapping ...$mappings): Mapping
    {
        $builder = new MappingBuilder();

        foreach ($mappings as $mapping) {
            foreach (get_object_vars($mapping) as $key => $value) {
                if ($builder->has($key)) {
                    continue;
                }

                $builder->$key = $value;
            }
        }

        return $builder->create();
    }
}
