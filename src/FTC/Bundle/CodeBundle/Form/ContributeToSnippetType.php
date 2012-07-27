<?php

namespace FTC\Bundle\CodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContributeToSnippetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', 'textarea', array(
                'label_render' => false,
                'attr'         => array('class' => 'code-comment-textarea', 'placeholder' => 'Refactored code to achieve more speed...'),
                'required'     =>false
            ))
            ->add('code', 'textarea', array('label_render' => false))
        ;
    }

    public function getName()
    {
        return 'ftc_bundle_codebundle_contributetype';
    }
}
