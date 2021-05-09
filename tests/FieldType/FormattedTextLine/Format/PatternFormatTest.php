<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\PatternFormat;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use PHPUnit\Framework\TestCase;

final class PatternFormatTest extends TestCase
{
    private const EXAMPLE_PATTERN = '/^[0-9]+$/';

    private const EXAMPLE_VALID_VALUE = '123';
    private const EXAMPLE_INVALID_VALUE = 'ABC';

    public function testValidate(): void
    {
        $fieldDefinition = $this->createMock(FieldDefinition::class);

        $format = new PatternFormat(self::EXAMPLE_PATTERN);

        $this->assertTrue($format->validate($fieldDefinition, self::EXAMPLE_VALID_VALUE));
        $this->assertFalse($format->validate($fieldDefinition, self::EXAMPLE_INVALID_VALUE));
    }
}
