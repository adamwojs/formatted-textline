<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine;

use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

interface Format
{
    public function validate(FieldDefinition $fieldDefinition, string $text): bool;
}
