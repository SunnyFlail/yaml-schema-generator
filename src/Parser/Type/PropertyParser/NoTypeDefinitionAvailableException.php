<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyParser;

final class NoTypeDefinitionAvailableException extends \LogicException
{
    public function __construct(
        public \ReflectionProperty $property
    ) {
        parent::__construct(sprintf(
            'No type definition available for %s::%s',
            $property->getDeclaringClass()->getShortName(),
            $property->getName()
        ));
    }
}
