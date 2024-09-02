<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Tests\data;

use SunnyFlail\YamlSchemaGenerator\Settings\ArrayItems;
use SunnyFlail\YamlSchemaGenerator\Settings\Description;
use SunnyFlail\YamlSchemaGenerator\Settings\Range;
use SunnyFlail\YamlSchemaGenerator\Settings\Required;
use SunnyFlail\YamlSchemaGenerator\Settings\Title;

#[Title('Base class')]
#[Description('Base class is a base class lol')]
final class BaseClass
{
    public string $baseString;
    public int $baseInt;
    public float $baseFloat;
    public bool $baseBool;
    public ?string $baseNullableString;
    #[ArrayItems(SubClass::class)]
    public array $arrayOfSubclasses;
    public SubClass $subclass;
    #[Range(0, 100)]
    public int $dupex;
    #[Range(minimum: 666)]
    public int $kupex;
    #[Range(maximum: 2137)]
    public int $zupex;
    #[Required(false)]
    public string $optional;
    #[Required]
    public string $required = 'DUPA';
}
