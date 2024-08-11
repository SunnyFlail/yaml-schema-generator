<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\FileSystem;

final class FileSystem implements FileSystemInterface
{
    public function save(string $path, string $contents): void
    {
        $dir = dirname($path);

        if (!is_writeable($dir)) {
            throw new NotWriteableException($path);
        }

        $file = fopen($path, 'w');

        if (!$file || false === fwrite($file, $contents)) {
            throw new FileSystemException($path);
        }
    }
}
