<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

interface ClassParserInterface
{
    public function parseClass(string $class): Mapping;
}
