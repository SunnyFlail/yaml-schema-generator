<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Tests\data;

enum StringEnum: string
{
    case FIRST_VALUE = 'first';
    case SECOND_VALUE = 'second';
    case THIRD_VALUE = 'third';
}
