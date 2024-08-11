<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class Title implements SettingsAttribute
{
    public function __construct(
        public string $title
    ) {}

    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'title',
            'value' => $this->title,
        ];
    }
}
