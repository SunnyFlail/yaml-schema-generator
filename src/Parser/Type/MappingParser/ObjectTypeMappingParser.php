<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;
use SunnyFlail\YamlSchemaGenerator\Parser\ClassParserInterface;

final readonly class ObjectTypeMappingParser implements TypeMappingParserStrategy
{
    public function __construct(
        private readonly ClassParserInterface $classParser
    ) {}

    public function supports(Type $type): bool
    {
        return Type::OBJECT === $type;
    }

    public function parse(\ReflectionProperty $property, Type $type, string $typeString): Mapping
    {
        return $this->classParser->parseClass($typeString);
    }
}
