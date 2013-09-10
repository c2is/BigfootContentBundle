<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetType extends AbstractType
{

    protected $container;

    /**
     * Constructor
     *
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

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
            ->add('position','hidden')
            ->add('sidebar');

        $currentPath = $this->container->get('kernel')->getBundle('BigfootContentBundle')->getPath();
        $tabTemplate = $this->container->get('bigfoot_content.template')->listTemplate($currentPath,'Widget');

        $builder
            ->add('template','choice',array(
                'choices' => $tabTemplate
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
