<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

final class NullFormat implements Format
{
    public function validate(FieldDefinition $fieldDefinition, string $text): bool
    {
        return true;
    }

    public function getMask(FieldDefinition $fieldDefinition): ?string
    {
        return null;
    }

    public function getExamples(FieldDefinition $fieldDefinition): array
    {
        return [];
    }
}
