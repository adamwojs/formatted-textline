<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

final class MakeTextLineFieldType extends AbstractMaker
{
    protected const FIELD_TYPE_NAME = 'name';
    protected const FIELD_TYPE_IDENTIFIER = 'identifier';

    public static function getCommandName(): string
    {
        return 'make:ibexa:textline-field-type';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Ibexa Text Line field type';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->addArgument(
            self::FIELD_TYPE_NAME,
            InputArgument::REQUIRED,
            'field type name e.g. Color'
        );

        $command->addOption(
            self::FIELD_TYPE_IDENTIFIER,
            null,
            InputArgument::OPTIONAL,
            'field type identifier e.g. ezcolor'
        );
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        /* Nothing to configure */
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        if (!$input->getArgument(self::FIELD_TYPE_NAME)) {
            $argument = $command->getDefinition()->getArgument(self::FIELD_TYPE_NAME);

            $question = new Question($argument->getDescription());
            $question->setValidator(static function (?string $value): string {
                if (null === $value || '' === $value) {
                    throw new RuntimeCommandException('This value cannot be blank.');
                }

                return $value;
            });

            $input->setArgument(self::FIELD_TYPE_NAME, $io->askQuestion($question));
        }

        if (!$input->getOption(self::FIELD_TYPE_IDENTIFIER)) {
            $input->setOption(self::FIELD_TYPE_IDENTIFIER, strtolower($input->getArgument(self::FIELD_TYPE_NAME)));
        }
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $fieldTypeInfo = $this->getFieldTypeInfoFromInput($input);

        $this->generateServicesConfiguration(
            $generator,
            $fieldTypeInfo,
            $this->generateTypeClass($generator, $fieldTypeInfo),
            $this->generateFormatClass($generator, $fieldTypeInfo)
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
    }

    private function generateTypeClass(Generator $generator, FieldTypeInfo $fieldTypeInfo): ClassNameDetails
    {
        $class = $fieldTypeInfo->getClassNameDetails($generator);

        $generator->generateClass(
            $class->getFullName(),
            $this->getTemplate('class/Type.tpl.php'),
            [
                'identifier' => $fieldTypeInfo->getIdentifier(),
            ]
        );

        return $class;
    }

    private function generateFormatClass(Generator $generator, FieldTypeInfo $fieldTypeInfo): ClassNameDetails
    {
        $class = $generator->createClassNameDetails('Format', $fieldTypeInfo->getNamespace());

        $generator->generateClass(
            $class->getFullName(),
            $this->getTemplate('class/Format.tpl.php')
        );

        return $class;
    }

    private function generateServicesConfiguration(
        Generator $generator,
        FieldTypeInfo $fieldTypeInfo,
        ClassNameDetails $typeClass,
        ClassNameDetails $formatClass
    ): void {
        $generator->generateFile(
            $fieldTypeInfo->getServicesPath($generator),
            $this->getTemplate('services/services.tpl.php'),
            [
                'field_type_identifier' => $fieldTypeInfo->getIdentifier(),
                'field_type_definition' => $fieldTypeInfo->getServiceDefinitionId(),
                'field_type_definition_class' => $typeClass->getFullName(),
                'format_class' => $formatClass->getFullName(),
            ]
        );
    }

    private function getFieldTypeInfoFromInput(InputInterface $input): FieldTypeInfo
    {
        $identifier = $input->getOption(self::FIELD_TYPE_IDENTIFIER);
        $namespace = 'FieldType\\' . $input->getArgument(self::FIELD_TYPE_NAME) . '\\';

        return new FieldTypeInfo($identifier, $namespace);
    }

    private function getTemplate(string $name): string
    {
        return __DIR__ . '/../Resources/skeleton/textline-field-type/' . $name;
    }
}
