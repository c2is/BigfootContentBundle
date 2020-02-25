<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\CoreBundle\Form\Type\BigfootDatepickerType;
use Bigfoot\Bundle\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'template',
                ChoiceType::class,
                array(
                    'required'          => true,
                    'expanded'          => true,
                    'multiple'          => false,
                    'data'              => $options['template'],
                    'choices_as_values' => true,
                    'choices'           => array_flip($options['data']->toStringTemplates($options['templates']))
                )
            )
            ->add(
                'name',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'right',
                        'data-popover'   => true,
                        'data-content'   => 'This is the name of the content in the back office. It will not be displayed to the web user.',
                        'data-title'     => 'Name',
                        'data-trigger'   => 'hover',
                    ),
                    'label' => 'bigfoot_content.page.type.name.label',
                )
            )
            ->add(
                'active',
                CheckboxType::class,
                array(
                    'required' => false,
                    'label' => 'bigfoot_content.page.type.active.label',
                )
            );

        if (isset($options['data']) && $options['data'] instanceof Page) {
            $builder
                ->add(
                    'publicationStartDate',
                    DateTimePickerType::class,
                    array(
                        'label' => 'bigfoot_content.page.type.publicationStartDate.label',
                    )
                )
                ->add(
                    'publicationEndDate',
                    DateTimePickerType::class,
                    array(
                        'label' => 'bigfoot_content.page.type.publicationEndDate.label',
                    )
                );
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'inherit_data' => true,
                'template'     => '',
                'templates'    => '',
                'label'        => false,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_content';
    }
}
