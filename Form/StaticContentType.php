<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StaticContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sidebar')
            ->add('label')
            ->add('title')
            ->add('description','bigfoot_richtext')
            ->add('media', 'bigfoot_media')
            ->add('position','hidden')
            ->add('active','checkbox',array('required' => false))
            ->add('template', 'entity', array(
                'class' => 'BigfootContentBundle:Template',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->where('t.type = :type')
                            ->orderBy('t.name')
                            ->setParameter('type', 'StaticContent');
                    },
            ))
            ->add('translation', 'translatable_entity')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\StaticContent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigfoot_bundle_contentbundle_staticcontenttype';
    }
}
