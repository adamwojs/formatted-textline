<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Tests\FieldType\FormattedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Type as FormattedTextLineType;

final class TypeStub extends FormattedTextLineType
{
    /** @var string */
    private $identifier;

    public function __construct(string $identifier, Format $format)
    {
        parent::__construct($format);

        $this->identifier = $identifier;
    }

    public function getFieldTypeIdentifier(): string
    {
        return $this->identifier;
    }
}
