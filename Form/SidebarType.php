<?php

namespace Bigfoot\Bundle\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SidebarType extends AbstractType
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
        $currentPath = $this->container->get('kernel')->getBundle('BigfootContentBundle')->getPath();
        $tabTemplate = $this->container->get('bigfoot_content.template')->listTemplate($currentPath,'Sidebar');

        $builder
            ->add('template','choice',array(
                'choices' => $tabTemplate
            ));

        $builder
            ->add('title')
            ->add('active','checkbox',array('required' => false));
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
