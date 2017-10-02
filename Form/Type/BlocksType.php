<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BlocksType
 * @package Bigfoot\Bundle\ContentBundle\Form\Type
 */
class BlocksType extends AbstractType
{
    /**
     * @return mixed
     */
    public function getParent()
    {
        return CollectionType::class;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
            [
                'prototype'    => true,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]
        );
    }
}
