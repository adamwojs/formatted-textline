<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\MaskedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\MaskedTextLine\Type;
use AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine\TypeTest as FormattedTextLineTypeTest;

final class TypeTest extends FormattedTextLineTypeTest
{
    public function provideFieldTypeIdentifier(): string
    {
        return 'masked_textline';
    }

    public function provideValidFieldSettings(): array
    {
        return [
            [
                [],
            ],
            [
                [
                    'mask' => '#00-000',
                ],
            ],
        ];
    }

    public function provideInValidFieldSettings(): array
    {
        return [
            [
                [
                    'unknown_setting' => true,
                ],
            ],
        ];
    }

    protected function getFieldTypeUnderTest(): Type
    {
        return new Type($this->format);
    }

    protected function getSettingsSchemaExpectation(): array
    {
        return [
            'mask' => [
                'type' => 'string',
                'default' => null,
            ],
        ];
    }
}
