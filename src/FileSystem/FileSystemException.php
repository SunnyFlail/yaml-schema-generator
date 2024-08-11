<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\FileSystem;

class FileSystemException extends \Exception
{
    public function __construct(
        public readonly string $path
    ) {
        parent::__construct($this->prepareMessage($path));
    }

    protected function prepareMessage(string $path): string
    {
        return sprintf(
            'An error occurred while saving to %s',
            $path
        );
    }
}
