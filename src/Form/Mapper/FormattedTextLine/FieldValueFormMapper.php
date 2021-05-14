<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Mapper\FormattedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format;
use AdamWojs\IbexaFormattedTextLineBundle\Form\Type\FormattedTextLineFieldType;
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;

class FieldValueFormMapper implements FieldValueFormMapperInterface
{
    /** @var \AdamWojs\IbexaFormattedTextLineBundle\FieldType\FormattedTextLine\Format */
    private $format;

    public function __construct(Format $format)
    {
        $this->format = $format;
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->fieldDefinition;

        $fieldForm->add(
            'value',
            FormattedTextLineFieldType::class,
            [
                'required' => $definition->isRequired,
                'label' => $definition->getName(),
                'mask' => $this->format->getMask($definition),
                'examples' => $this->format->getExamples($definition),
            ]
        );
    }
}
