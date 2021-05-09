<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;

final class PatternFormat implements Format
{
    /** @var string */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function validate(FieldDefinition $fieldDefinition, string $text): bool
    {
        return preg_match($this->pattern, $text) === 1;
    }
}
