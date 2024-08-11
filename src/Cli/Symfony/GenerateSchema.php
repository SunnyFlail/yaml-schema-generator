<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Cli\Symfony;

use SunnyFlail\YamlSchemaGenerator\FileSystem\FileSystemInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\ClassParserInterface;
use SunnyFlail\YamlSchemaGenerator\Serializer\MappingSerializerInterface;
use Symfony\Component\Console\SingleCommandApplication;

final class GenerateSchema extends SingleCommandApplication
{
    use GenerateSchemaCommandTrait;

    public function __construct(
        private readonly ClassParserInterface $classParser,
        private readonly MappingSerializerInterface $serializer,
        private readonly FileSystemInterface $fileSystem
    ) {
        parent::__construct('generate-schema');
    }
}
