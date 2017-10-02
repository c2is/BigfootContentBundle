<?php
/**
 * Created by PhpStorm.
 * User: guillaume
 * Date: 29/06/16
 * Time: 15:10
 */

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SidebarsType
 * @package Bigfoot\Bundle\ContentBundle\Form\Type
 */
class SidebarsType extends AbstractType
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
