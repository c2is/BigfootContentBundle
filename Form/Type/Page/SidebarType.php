<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SidebarType
 * @package Bigfoot\Bundle\ContentBundle\Form\Type\Page
 */
class SidebarType extends AbstractType
{
    /** @var array */
    protected $templates;

    /**
     * @param array $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'sidebar',
                EntityType::class,
                [
                    'class'         => 'Bigfoot\Bundle\ContentBundle\Entity\Sidebar',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')->orderBy('s.name', 'ASC');
                    },
                ]
            )
            ->add('position')
            ->add(
                'template',
                ChoiceType::class,
                [
                    'required'          => true,
                    'expanded'          => true,
                    'multiple'          => false,
                    'choices_as_values' => true,
                    'choices'           => array_flip($this->toStringTemplates($this->templates)),
                ]
            );
    }

    /**
     * @param array $templates
     *
     * @return array
     */
    public function toStringTemplates(array $templates)
    {
        $nTemplates = [];

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key.'/'.$subTemplates] = $label;
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar',
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_sidebar';
    }
}
