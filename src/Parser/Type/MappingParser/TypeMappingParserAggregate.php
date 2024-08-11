<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\MappingParser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;
use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class TypeMappingParserAggregate implements TypeMappingParserInterface
{
    /**
     * @var TypeMappingParserStrategy[]
     */
    private array $strategies;

    public function __construct(
        TypeMappingParserStrategy ...$strategies
    ) {
        $this->strategies = $strategies;
    }

    public function parse(\ReflectionProperty $property, Type $type, string $typeString): Mapping
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy->parse($property, $type, $typeString);
            }
        }

        throw new \LogicException();
    }
}
