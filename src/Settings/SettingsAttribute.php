<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Settings;

interface SettingsAttribute
{
    /**
     * @return array{name: string, value: string|bool}
     */
    public function getSettingNameAndValue(): array;
}
