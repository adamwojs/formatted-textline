<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Mapper\MaskedTextLine;

use AdamWojs\IbexaFormattedTextLineBundle\Form\Type\MaskedTextLineFieldType;
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;

final class FieldValueFormMapper implements FieldValueFormMapperInterface
{
    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->fieldDefinition;

        $fieldForm->add('value', MaskedTextLineFieldType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName(),
            'mask' => $definition->fieldSettings['mask'],
        ]);
    }
}
