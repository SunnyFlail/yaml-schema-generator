<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\FileSystem;

final class NotWriteableException extends FileSystemException
{
    protected function prepareMessage(string $path): string
    {
        return sprintf(
            'Cannot write to %s',
            $path
        );
    }
}
