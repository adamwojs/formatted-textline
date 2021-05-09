<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Type;
use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Value;
use eZ\Publish\API\Repository\Exceptions\InvalidArgumentException;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\SPI\FieldType\Tests\FieldTypeTest;

class TypeTest extends FieldTypeTest
{
    private const FIELD_TYPE_IDENTIFIER = 'custom_text_line';

    /** @var \AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format */
    protected $format;

    protected function setUp(): void
    {
        $this->format = $this->createMock(Format::class);
    }

    public function provideInvalidInputForAcceptValue(): array
    {
        return [
            [
                0xFFFF,
                InvalidArgumentException::class,
            ],
            [
                $this->createMock(ValueObject::class),
                InvalidArgumentException::class,
            ],
        ];
    }

    public function provideValidInputForAcceptValue(): array
    {
        return [
            [
                null,
                new Value(),
            ],
            [
                '',
                new Value(),
            ],
            [
                'example',
                new Value('example'),
            ],
            [
                new Value('example'),
                new Value('example'),
            ],
            [
                new Value(null),
                new Value(),
            ],
        ];
    }

    public function provideInputForToHash(): array
    {
        return [
            [
                new Value(),
                null,
            ],
            [
                new Value(''),
                null,
            ],
            [
                new Value('example'),
                'example',
            ],
        ];
    }

    public function provideInputForFromHash(): array
    {
        return [
            [
                null,
                new Value(),
            ],
            [
                '',
                new Value(),
            ],
            [
                'example',
                new Value('example'),
            ],
        ];
    }

    public function provideDataForGetName(): array
    {
        return [
            [new Value(), [], 'eng-GB', ''],
            [new Value('example'), [], 'eng-GB', 'example'],
        ];
    }

    /**
     * @dataProvider provideValidDataForValidate
     */
    public function testValidateValid($fieldDefinitionData, $value): void
    {
        $fieldDefinitionMock = $this->createMock(FieldDefinition::class);

        $this->format
            ->method('validate')
            ->with($fieldDefinitionMock, $value->getText())
            ->willReturn(true);

        $validationErrors = $this->getFieldTypeUnderTest()->validate($fieldDefinitionMock, $value);

        $this->assertIsArray($validationErrors);
        $this->assertEmpty($validationErrors, "Got value:\n" . var_export($validationErrors, true));
    }

    public function provideValidDataForValidate(): array
    {
        return [
            [
                [],
                new Value(),
            ],
            [
                [],
                new Value('1'),
            ],
        ];
    }

    /**
     * @dataProvider provideInvalidDataForValidate
     */
    public function testValidateInvalid($fieldDefinitionData, $value, $errors): void
    {
        $fieldDefinitionMock = $this->createMock(FieldDefinition::class);

        $this->format
            ->method('validate')
            ->with($fieldDefinitionMock, $value->getText())
            ->willReturn(false);

        $validationErrors = $this->getFieldTypeUnderTest()->validate($fieldDefinitionMock, $value);

        $this->assertIsArray($validationErrors);
        $this->assertEquals($errors, $validationErrors);
    }

    public function provideInvalidDataForValidate(): array
    {
        return [
            [
                [],
                new Value('0'),
                [
                    new ValidationError(
                        "The string doesn't match specified format.",
                        null,
                        [],
                        'text'
                    ),
                ],
            ],
        ];
    }

    protected function provideFieldTypeIdentifier(): string
    {
        return self::FIELD_TYPE_IDENTIFIER;
    }

    protected function createFieldTypeUnderTest(): Type
    {
        return new TypeStub(self::FIELD_TYPE_IDENTIFIER, $this->format);
    }

    protected function getValidatorConfigurationSchemaExpectation(): array
    {
        return [];
    }

    protected function getSettingsSchemaExpectation(): array
    {
        return [];
    }

    protected function getEmptyValueExpectation(): Value
    {
        return new Value();
    }
}
