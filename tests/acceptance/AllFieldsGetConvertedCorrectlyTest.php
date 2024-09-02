<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Tests\acceptance;

use PHPUnit\Framework\TestCase;
use SunnyFlail\YamlSchemaGenerator\Misc\Container;
use SunnyFlail\YamlSchemaGenerator\Tests\data\BaseClass;

final class AllFieldsGetConvertedCorrectlyTest extends TestCase
{
    public function testAllFieldsGetConvertedCorrectly(): void
    {
        $class = BaseClass::class;

        $expectedSubclass = [
            "title" => "Sub class",
            "description" => "Sub class is a sub class dummy",
            "type" => "object",
            "properties" => [
                "subString" => [
                    "type" => "string",
                ],
                "subInt" => [
                    "type" => "number",
                ],
                "subFloat" => [
                    "type" => "number",
                ],
                "subBool" => [
                    "type" => "boolean",
                ],
                "subNullableString" => [
                    "type" => ["string", "null"],
                ],
                "arrayOfBools" => [
                    "type" => "array",
                    "items" => [
                        "type" => "boolean",
                    ],
                ],
                "arrayOfNumbersOrStrings" => [
                    "type" => "array",
                    "items" => [
                        "type" => ["number", "string"],
                    ],
                ],
            ],
            "required" => [
                "subString",
                "subInt",
                "subFloat",
                "subBool",
                "arrayOfBools",
                "arrayOfNumbersOrStrings",
                "subNullableString",
            ]
        ];
        $expected = [
            "title" => "Base class",
            "description" => "Base class is a base class lol",
            "type" => "object",
            "properties" => [
                "baseString" => [
                    "type" => "string",
                ],
                "baseInt" => [
                    "type" => "number",
                ],
                "baseFloat" => [
                    "type" => "number",
                ],
                "baseBool" => [
                    "type" => "boolean",
                ],
                "baseNullableString" => [
                    "type" => ["string", "null"],
                ],
                "arrayOfSubclasses" => [
                    "type" => "array",
                    "items" => $expectedSubclass,
                ],
                "subclass" => $expectedSubclass,
                "dupex" => [
                    "type" => "number",
                    "minimum" => 0,
                    "maximum" => 100
                ],
                "kupex" => [
                    "type" => "number",
                    "minimum" => 666
                ],
                "zupex" => [
                    "type" => "number",
                    "maximum" => 2137
                ],
                "optional" => [
                    "type" => "string",
                ],
                "required" => [
                    "type" => "string",
                ],
            ],
            "required" => [
                "baseString",
                "baseInt",
                "baseFloat",
                "baseBool",
                "baseNullableString",
                "arrayOfSubclasses",
                "subclass",
                "dupex",
                "kupex",
                "zupex",
                "required",
            ]
        ];

        $SUT = (new Container())->createClassParser();

        $result = $SUT->parseClass($class);
        $result = json_decode(json_encode($result), true);
        //var_dump($result);
        $expectedFieldNames = [];

        foreach ($expected as $key => $value) {
            $expectedFieldNames[$key] = true;

            $this->assertEqualsCanonicalizing($value, $result[$key] ?? null);
        }

        foreach ($result as $key => $value) {
            if (isset($expectedFieldNames[$key])) {
                continue;
            }

            $this->fail(sprintf('Result has unknown field "%s"', $key));
        }
    }
}
