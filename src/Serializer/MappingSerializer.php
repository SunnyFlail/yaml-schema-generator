<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Serializer;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

final readonly class MappingSerializer implements MappingSerializerInterface
{
    public function serialize(Mapping $mapping): string
    {
        return json_encode($mapping, JSON_PRETTY_PRINT);
    }
}
