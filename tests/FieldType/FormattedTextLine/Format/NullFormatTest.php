<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format\NullFormat;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use PHPUnit\Framework\TestCase;

final class NullFormatTest extends TestCase
{
    private const EXAMPLE_VALUE = 'Lorem ipsum dolor...';

    public function testValidate(): void
    {
        $format = new NullFormat();

        $fieldDefinition = $this->createMock(FieldDefinition::class);

        $this->assertTrue($format->validate($fieldDefinition, self::EXAMPLE_VALUE));
    }
}
