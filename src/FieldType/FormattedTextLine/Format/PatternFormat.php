<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;

final class PatternFormat implements Format
{
    /** @var string */
    private $pattern;

    /** @var string|null */
    private $mask;

    /** @var string[] */
    private $examples;

    public function __construct(string $pattern, ?string $mask = null, array $examples = [])
    {
        $this->pattern = $pattern;
        $this->mask = $mask;
        $this->examples = $examples;
    }

    public function validate(FieldDefinition $fieldDefinition, string $text): bool
    {
        return preg_match($this->pattern, $text) === 1;
    }

    public function getMask(FieldDefinition $fieldDefinition): ?string
    {
        return $this->mask;
    }

    public function getExamples(FieldDefinition $fieldDefinition): array
    {
        return $this->examples;
    }
}
