<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\Type\PropertyOptionalityResolver;

use SunnyFlail\YamlSchemaGenerator\Settings\Required;

final readonly class PropertyOptionalityResolver implements PropertyOptionalityResolverInterface
{
    public function isPropertyRequired(\ReflectionProperty $property): bool
    {
        $required = $property->getAttributes(Required::class);

        if ($required) {
            return $required[0]->newInstance()->required;
        }

        return !$property->hasDefaultValue();
    }
}
