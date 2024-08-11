<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class Id implements SettingsAttribute
{
    public function __construct(
        public string $id
    ) {}

    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'id',
            'value' => $this->id,
        ];
    }
}
