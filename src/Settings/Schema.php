<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class Schema implements SettingsAttribute
{
    public function __construct(
        public string $schema
    ) {}

    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'schema',
            'value' => $this->schema,
        ];
    }
}
