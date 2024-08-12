<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final readonly class Ref implements SettingsAttribute
{
    public function __construct(
        public string $ref
    ) {}

    public function getSettingNameAndValue(): array
    {
        return [
            'name' => 'ref',
            'value' => $this->ref,
        ];
    }
}
