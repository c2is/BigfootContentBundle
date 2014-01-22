<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label','hidden')
            ->add('name','hidden')
            ->add('route','hidden')
            ->add('position')
            ->add('sidebar')
            ->add('params','collection',array(
                'prototype' => false,
                'allow_add' => true,
            ))
            ->add('template', 'entity', array(
                'class' => 'BigfootContentBundle:Template',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.name');
                    },
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigfoot_bundle_contentbundle_widgettype';
    }
}
