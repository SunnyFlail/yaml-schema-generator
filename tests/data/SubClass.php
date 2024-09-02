<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Tests\data;

use SunnyFlail\YamlSchemaGenerator\Settings\ArrayItems;
use SunnyFlail\YamlSchemaGenerator\Settings\Description;
use SunnyFlail\YamlSchemaGenerator\Settings\Title;

#[Title('Sub class')]
#[Description('Sub class is a sub class dummy')]
final readonly class SubClass
{
    public string $subString;
    public int $subInt;
    public float $subFloat;
    public bool $subBool;
    public ?string $subNullableString;
    #[ArrayItems('bool')]
    public array $arrayOfBools;
    #[ArrayItems('int', 'string')]
    public array $arrayOfNumbersOrStrings;
}
