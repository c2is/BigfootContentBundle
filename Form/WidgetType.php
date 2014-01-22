<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('name','hidden')
            ->add('route','hidden')
            ->add('position','hidden')
            ->add('sidebar')
            ->add('template', 'entity', array(
                'class' => 'BigfootContentBundle:Template',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->where('t.type = :type')
                            ->orderBy('t.name')
                            ->setParameter('type', 'Widget');
                    },
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Widget',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'id',
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
