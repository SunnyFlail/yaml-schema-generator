<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_PROPERTY)]
final readonly class Description implements SettingsAttribute
{
    public function __construct(
        public string $description
    ) {}

    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'description',
            'value' => $this->description,
        ];
    }
}
