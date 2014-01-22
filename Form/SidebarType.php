<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SidebarType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sidebarCategory', 'entity', array(
                'class' => 'BigfootContentBundle:SidebarCategory',
                'property' => 'title',

            ))
            ->add('template', 'entity', array(
                'class' => 'BigfootContentBundle:Template',
                'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->where('t.type = :type')
                            ->orderBy('t.name')
                            ->setParameter('type', 'Sidebar');
                    },
            ))
            ->add('title', 'text')
            ->add('slug', 'text', array('disabled'   => true))
            ->add('active','checkbox',array('required' => false))
            ->add('translation', 'translatable_entity')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Sidebar'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bigfoot_bundle_contentbundle_sidebartype';
    }
}
