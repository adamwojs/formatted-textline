<?php

declare(strict_types=1);

namespace AdamWojs\IbexaFormattedTextLineBundle\Form\Type;

use AdamWojs\IbexaFormattedTextLineBundle\Form\DataTransformer\TextLineFieldTypeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class TextLineFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextType::class, [
            'label' => false,
        ]);

        $builder->addModelTransformer(new TextLineFieldTypeTransformer());
    }
}
