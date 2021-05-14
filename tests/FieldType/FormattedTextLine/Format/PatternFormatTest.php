<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\PatternFormat;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use PHPUnit\Framework\TestCase;

final class PatternFormatTest extends TestCase
{
    private const FORMAT_PATTERN = '/^[0-9]+$/';
    private const FORMAT_MASK = '#000000';
    private const FORMAT_EXAMPLES = ['1', '2', '3', '5'];

    private const EXAMPLE_VALID_VALUE = '123';
    private const EXAMPLE_INVALID_VALUE = 'ABC';

    /** @var \AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\NullFormat */
    private $format;

    /** @var \eZ\Publish\API\Repository\Values\ContentType\FieldDefinition */
    private $fieldDefinition;

    protected function setUp(): void
    {
        $this->format = new PatternFormat(
            self::FORMAT_PATTERN,
            self::FORMAT_MASK,
            self::FORMAT_EXAMPLES
        );

        $this->fieldDefinition = $this->createMock(FieldDefinition::class);
    }

    public function testValidate(): void
    {
        $this->assertTrue($this->format->validate($this->fieldDefinition, self::EXAMPLE_VALID_VALUE));
        $this->assertFalse($this->format->validate($this->fieldDefinition, self::EXAMPLE_INVALID_VALUE));
    }

    public function testGetMask(): void
    {
        $this->assertEquals(
            self::FORMAT_MASK,
            $this->format->getMask($this->fieldDefinition)
        );
    }

    public function testGetExamples(): void
    {
        $this->assertEquals(
            self::FORMAT_EXAMPLES,
            $this->format->getExamples($this->fieldDefinition)
        );
    }
}
