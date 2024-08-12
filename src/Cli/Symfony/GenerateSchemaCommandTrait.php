<?php

declare(strict_types=1);

namespace SunnyFlail\YamlSchemaGenerator\Cli\Symfony;

use SunnyFlail\YamlSchemaGenerator\FileSystem\FileSystemInterface;
use SunnyFlail\YamlSchemaGenerator\Parser\ClassParserInterface;
use SunnyFlail\YamlSchemaGenerator\Serializer\MappingSerializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait GenerateSchemaCommandTrait
{
    private const ARG_CLASS = 'class';
    private const ARG_OUTPUT = 'output';

    private const OPT_AUTOLOAD = 'autoload';
    private const OPT_CLASS_FILE = 'file';

    private const OPTION_REQUIRES_FILE = [
        self::OPT_AUTOLOAD,
        self::OPT_CLASS_FILE,
    ];

    private readonly ClassParserInterface $classParser;
    private readonly MappingSerializerInterface $serializer;
    private readonly FileSystemInterface $fileSystem;

    protected function configure()
    {
        $this->addArgument(
            self::ARG_CLASS,
            InputArgument::REQUIRED,
            'Base class to generate schema from'
        );

        $this->addArgument(
            self::ARG_OUTPUT,
            InputArgument::REQUIRED,
            'Path to output generated schema'
        );

        $this->addOption(
            self::OPT_AUTOLOAD,
            'a',
            InputOption::VALUE_REQUIRED,
            'Path to autoload file',
        );

        $this->addOption(
            self::OPT_CLASS_FILE,
            'f',
            InputOption::VALUE_REQUIRED,
            'Path to file containing class provided as argument'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->requireFiles($input);

        $outputPath = $this->getOutputPath($input);

        $this->fileSystem->save(
            $outputPath,
            $this->serializer->serialize(
                $this->classParser->parseClass(
                    $input->getArgument(self::ARG_CLASS)
                )
            )
        );

        $io->success(sprintf(
            'Successfully saved to %s',
            $outputPath
        ));

        return Command::SUCCESS;
    }

    private function getOutputPath(InputInterface $input): string
    {
        $outputPath = $input->getArgument(self::ARG_OUTPUT);
        $isLocalPath = str_starts_with($outputPath, './');

        if (!$isLocalPath || str_starts_with($outputPath, '/')) {
            return $outputPath;
        }

        if ($isLocalPath) {
            $outputPath = substr($outputPath, 2);
        }

        return getcwd().'/'.$outputPath;
    }

    private function requireFiles(InputInterface $input): void
    {
        foreach (self::OPTION_REQUIRES_FILE as $optName) {
            $filePath = $input->getOption($optName);

            if ($filePath) {
                if (!file_exists($filePath)) {
                    throw new \Exception(sprintf('File %s not found', $filePath));
                }

                require_once $filePath;
            }
        }
    }
}
