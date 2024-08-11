<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Parser\MappingBuilder;

use SunnyFlail\YamlSchemaGenerator\Mapping\Mapping;

final class MappingBuilder
{
    private array $properties;
    private \ReflectionClass $reflection;

    public function __construct()
    {
        $this->properties = [];
        $this->reflection = new \ReflectionClass(Mapping::class);
    }

    public function has(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    public function __set($name, $value)
    {
        $this->validatePropertyExists($name);

        $this->properties[$name] = $value;
    }

    public function __get($name)
    {
        $this->validatePropertyExists($name);

        return $this->properties[$name] ?? null;
    }

    public function create(): Mapping
    {
        $mapping = $this->reflection->newInstanceWithoutConstructor();

        foreach ($this->properties as $key => $value) {
            $this->reflection->getProperty($key)->setValue($mapping, $value);
        }

        return $mapping;
    }

    private function validatePropertyExists(string $name): void
    {
        if (!$this->reflection->hasProperty($name)) {
            throw new \LogicException(sprintf('Property %s does not exist in Mapping', $name));
        }
    }
}
