<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MaskedTextType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars += [
            'mask' => $options['mask'],
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mask' => null,
        ]);

        $resolver->setAllowedTypes('mask', ['string', 'null']);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
