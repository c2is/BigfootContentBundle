<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', 'entity', array(
                'class' => 'BigfootContentBundle:Template',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.type = :type')
                        ->orderBy('t.name')
                        ->setParameter('type', 'Page');
                },
            ))
            ->add('name', 'text', array(
                'attr' => array(
                    'data-placement'    => 'bottom',
                    'data-popover'      => true,
                    'data-content'      => 'This is the name of the page in the back office. It will not be displayed to the web user.',
                    'data-title'        => 'Name',
                    'data-trigger'      => 'hover',
                    'data-placement'    => 'right'
                )
            ))
            ->add('slug', 'text', array(
                'attr' => array(
                    'data-placement'    => 'bottom',
                    'data-popover'      => true,
                    'data-content'      => 'This value is used to generate urls. Should contain only lower case letters and the \'-\' sign.',
                    'data-title'        => 'Slug',
                    'data-trigger'      => 'hover',
                    'data-placement'    => 'right'
                ),
            ))
            ->add('title', 'text', array(
                'attr' => array(
                    'data-placement'    => 'bottom',
                    'data-popover'      => true,
                    'data-content'      => 'This is the title of the page as displayed to the web user.',
                    'data-title'        => 'Title',
                    'data-trigger'      => 'hover',
                    'data-placement'    => 'right'
                )
            ))
            ->add('description','bigfoot_richtext')
            ->add('image','bigfoot_media', array('required' => false))
            ->add('active','checkbox',array('required' => false));

        $builder
            ->add('translation', 'translatable_entity')
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigfoot_bundle_contentbundle_pagetype';
    }
}
