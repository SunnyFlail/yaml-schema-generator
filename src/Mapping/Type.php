<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Mapping;

enum Type: string
{
    case STRING = 'string';
    case ARRAY = 'array';
    case BOOLEAN = 'boolean';
    case NUMBER = 'number';
    case OBJECT = 'object';
    case NULL = 'null';
}
