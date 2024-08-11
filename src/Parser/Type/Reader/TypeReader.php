<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class TypeReader implements TypeReaderInterface
{
    /**
     * @return string[]
     */
    public function toStrings(\ReflectionType $type): array
    {
        $types = $this->toArray($type);

        if ($type->allowsNull()) {
            $types[] = Type::NULL->value;
        }

        return array_unique($types);
    }

    /**
     * @return string[]
     */
    private function toArray(\ReflectionType $type): array
    {
        return match (true) {
            $type instanceof \ReflectionUnionType => throw new \LogicException('Union types not yet supported'),
            $type instanceof \ReflectionNamedType => [$type->getName()],
            $type instanceof \ReflectionIntersectionType => (
                function (\ReflectionIntersectionType $type): array {
                    $types = [];

                    foreach ($type->getTypes() as $type) {
                        foreach ($this->toArray($type) as $options) {
                            $types[] = $options;
                        }
                    }

                    return $types;
                }
            )($type)
        };
    }
}
