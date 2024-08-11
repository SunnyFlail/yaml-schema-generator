<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class Deprecated implements SettingsAttribute
{
    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'deprecated',
            'value' => true,
        ];
    }
}
