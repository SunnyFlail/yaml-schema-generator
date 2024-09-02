<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Mapping;

use SunnyFlail\YamlSchemaGenerator\Validator\Attribute\KeyType;
use SunnyFlail\YamlSchemaGenerator\Validator\Attribute\RequiredItemType;
use SunnyFlail\YamlSchemaGenerator\Validator\Attribute\RequiredKeyType;

final readonly class Mapping implements \JsonSerializable
{
    private const DOLLAR_PREFIXED_PROPERTIES = [
        'ref',
        'schema',
    ];

    private const ARRAYS_TO_FLATTEN_ON_SINGLE_VALUE = [
        'type',
        'oneOf',
        'allOf',
        'anyOf',
    ];

    private const META_PROPERTIES = [
        'classFqcn',
        'isComplexType',
    ];

    public string $classFqcn;

    public bool $isComplexType;

    public string $ref;

    public string $schema;

    public string $id;

    public string $title;

    public string $description;

    /**
     * @var Type|Type[] $type
     */
    #[RequiredItemType(Type::STRING->value)]
    #[RequiredKeyType(KeyType::NUMBER)]
    public array $type;

    public Mapping $items;

    public bool $uniqueItems;

    /**
     * @var string[]|int[]
     */
    #[RequiredItemType(Type::STRING->value)]
    #[RequiredItemType(Type::NUMBER->value)]
    #[RequiredKeyType(KeyType::NUMBER)]
    public array $enum;

    /**
     * @var Mapping[]
     */
    #[RequiredItemType(self::class)]
    #[RequiredKeyType(KeyType::NUMBER)]
    public array $oneOf;

    /**
     * @var Mapping[]
     */
    #[RequiredItemType(self::class)]
    #[RequiredKeyType(KeyType::NUMBER)]
    public array $allOf;

    /**
     * @var array<string,Mapping>
     */
    #[RequiredItemType(self::class)]
    #[RequiredKeyType(KeyType::STRING)]
    public array $properties;

    /**
     * @var array<string,Mapping>
     */
    #[RequiredItemType(self::class)]
    #[RequiredKeyType(KeyType::STRING)]
    public array $patternProperties;

    public bool $additionalProperties;

    /**
     * @var array<string,Mapping>
     */
    #[RequiredItemType(self::class)]
    #[RequiredKeyType(KeyType::STRING)]
    public array $definitions;

    public int|float $minimum;

    public int|float $maximum;

    public int|float $exclusiveMinimum;
    public int|float $exclusiveMaximum;

    public int $minLength;

    public int $maxLength;

    public string $pattern;

    /**
     * @var string[]
     */
    #[RequiredItemType(Type::STRING->value)]
    #[RequiredKeyType(KeyType::NUMBER)]
    public array $required;

    public function jsonSerialize(): array
    {
        $arr = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (in_array($key, self::META_PROPERTIES)) {
                continue;
            }

            if (in_array($key, self::DOLLAR_PREFIXED_PROPERTIES)) {
                $key = '$'.$key;
            }

            if (
                in_array($key, self::ARRAYS_TO_FLATTEN_ON_SINGLE_VALUE)
                && is_array($value)
                && 1 === count($value)
            ) {
                $value = array_pop($value);
            }

            $arr[$key] = $value;
        }

        return $arr;
    }
}
