<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine;

use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

interface Format
{
    /**
     * Validate value against format.
     */
    public function validate(FieldDefinition $fieldDefinition, string $text): bool;

    /**
     * Returns input mask for format.
     */
    public function getMask(FieldDefinition $fieldDefinition): ?string;

    /**
     * Returns examples of correct value.
     *
     * @return string[]
     */
    public function getExamples(FieldDefinition $fieldDefinition): array;
}
