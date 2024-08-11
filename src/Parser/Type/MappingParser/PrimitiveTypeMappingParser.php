<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder\MappingBuilder;
use SunnyFlail\YamlSchemaGenerator\Parser\MetaProperty\MetaPropertyLoaderInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader\TypeReaderInterface;
use SunnyFlail\YamlSchemaGenerator\Settings\Range;

final readonly class PrimitiveTypeMappingParser implements TypeMappingParserStrategy
{
    public function __construct(
        private TypeReaderInterface $typeReader,
        private MetaPropertyLoaderInterface $metaPropertyLoader
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

        if (Type::BOOLEAN === $type || Type::NULL === $type) {
            return $builder->create();
        }

        if (enum_exists($typeString)) {
            $enum = (new \ReflectionEnum($typeString));
            $allowedValues = [];

            foreach ($enum->getCases() as $case) {
                $allowedValues = $case->getValue();
            }

            $builder->enum = $allowedValues;
        }

        if (Type::NUMBER === $type) {
            $this->addIntegerProperties($builder, $property);
        }

        return $builder->create();
    }

    private function addIntegerProperties(
        MappingBuilder $builder,
        \ReflectionProperty $property
    ): void {
        $attributes = $property->getAttributes(Range::class);

        foreach ($attributes as $attribute) {
            $attribute = $attribute->newInstance();

            if (null !== $attribute->minimum) {
                $builder->minimum = $attribute->minimum;
                $builder->isComplexType = true;
            }

            if (null !== $attribute->maximum) {
                $builder->maximum = $attribute->maximum;
                $builder->isComplexType = true;
            }
        }
    }
}
