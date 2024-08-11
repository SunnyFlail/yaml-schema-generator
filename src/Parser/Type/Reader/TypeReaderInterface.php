<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\Reader;

interface TypeReaderInterface
{
    public function toStrings(\ReflectionType $type): array;
}
