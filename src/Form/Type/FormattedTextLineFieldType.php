<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Type;

use AdamWojs\IbexaFormattedTextLineBundle\Form\DataTransformer\FormattedTextLineFieldTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FormattedTextLineFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $help = null;
        if (!empty($options['examples'])) {
            $help = 'e.g. ' . implode(', ', $options['examples']);
        }

        $builder->add('text', MaskedTextType::class, [
            'label' => false,
            'mask' => $options['mask'],
            'help' => $help,
        ]);

        $builder->addModelTransformer(new FormattedTextLineFieldTypeTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mask' => null,
            'examples' => [],
        ]);

        $resolver->setAllowedTypes('mask', ['string', 'null']);
        $resolver->setAllowedTypes('examples', ['array']);
    }
}
