<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\DataTransformer;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Value;
use Symfony\Component\Form\DataTransformerInterface;

final class TextLineFieldTypeTransformer implements DataTransformerInterface
{
    public function transform($value): ?array
    {
        if (empty($value)) {
            return null;
        }

        return [
            'text' => $value,
        ];
    }

    public function reverseTransform($value): ?Value
    {
        if (empty($value)) {
            return null;
        }

        return new Value($value['text']);
    }
}
