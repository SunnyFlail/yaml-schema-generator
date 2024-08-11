<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Validator\Attribute;

enum KeyType
{
    /**
     * For lists - incrementing integer indexed arrays.
     */
    case NUMBER;

    /**
     * For dictionaries - string indexed arrays.
     */
    case STRING;
}
