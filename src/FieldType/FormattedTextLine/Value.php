<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine;

use Ibexa\Core\FieldType\Value as BaseValue;

final class Value extends BaseValue
{
    /** @var string|null */
    private $text;

    public function __construct(?string $text = null)
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function __toString(): string
    {
        return (string)$this->text;
    }
}
