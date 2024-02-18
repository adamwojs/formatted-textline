<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Type;

use AdamWojs\IbexaFormattedTextLineBundle\Form\DataTransformer\FormattedTextLineFieldTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class FormattedTextLineFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new FormattedTextLineFieldTypeTransformer());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars += [
            'mask' => $options['mask'],
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mask' => null,
            'examples' => [],
            'help' => static function (Options $options): ?string {
                if (!empty($options['examples'])) {
                    return 'e.g. ' . implode(', ', $options['examples']);
                }

                return null;
            },
        ]);

        $resolver->setAllowedTypes('mask', ['string', 'null']);
        $resolver->setAllowedTypes('examples', ['array']);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
