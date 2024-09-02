<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\Resolver;

use SunnyFlail\YamlSchemaGenerator\Mapping\Type;

final readonly class TypeResolver implements TypeResolverInterface
{
    private const NUMBER_TYPES = ['int', 'float'];

    public function resolveType(string $typeString): Type
    {
        $type = Type::tryFrom($typeString);

        switch (true) {
            case (bool) $type:
                return $type;
            case in_array($typeString, self::NUMBER_TYPES):
                return Type::NUMBER;
            case 'bool' === $typeString:
                return Type::BOOLEAN;
            case enum_exists($typeString):
                return $this->resolveEnumType($typeString);
            default:
                return Type::OBJECT;
        }
    }

    private function resolveEnumType(string $typeString): Type
    {
        $reflection = new \ReflectionEnum($typeString);

        if (!$reflection->isBacked()) {
            throw new \Exception('Not backed enums are not supported!');
        }

        /** @psalm-suppress UndefinedMethod */
        return $this->resolveType($reflection->getBackingType()->getName());
    }
}
