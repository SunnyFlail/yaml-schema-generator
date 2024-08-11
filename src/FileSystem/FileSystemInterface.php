<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\FileSystem;

interface FileSystemInterface
{
    /**
     * @throws FileSystemException
     */
    public function save(string $path, string $contents): void;
}
