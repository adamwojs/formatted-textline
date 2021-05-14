<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\NullFormat;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use PHPUnit\Framework\TestCase;

final class NullFormatTest extends TestCase
{
    private const EXAMPLE_VALUE = 'Lorem ipsum dolor...';

    /** @var \AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\NullFormat */
    private $format;

    /** @var \eZ\Publish\API\Repository\Values\ContentType\FieldDefinition */
    private $fieldDefinition;

    protected function setUp(): void
    {
        $this->format = new NullFormat();
        $this->fieldDefinition = $this->createMock(FieldDefinition::class);
    }

    public function testValidate(): void
    {
        $this->assertTrue($this->format->validate($this->fieldDefinition, self::EXAMPLE_VALUE));
    }

    public function testGetExamples(): void
    {
        $this->assertEmpty($this->format->getExamples($this->fieldDefinition));
    }

    public function testGetMask(): void
    {
        $this->assertNull($this->format->getMask($this->fieldDefinition));
    }
}
