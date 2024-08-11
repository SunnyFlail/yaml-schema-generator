<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Serializer;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

interface MappingSerializerInterface
{
    public function serialize(Mapping $mapping): string;
}
