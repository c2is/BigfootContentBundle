<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Bigfoot\Bundle\ContentBundle\Form\Type\BlocksType;
use Bigfoot\Bundle\ContentBundle\Form\Type\Page\BlockType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Bigfoot\Bundle\ContentBundle\Form\Type\ContentType;
use Bigfoot\Bundle\CoreBundle\Form\Type\BigfootRichtextType;
use Bigfoot\Bundle\CoreBundle\Form\Type\TranslatedEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Bigfoot\Bundle\MediaBundle\Form\Type\BigfootMediaType;

class TitleDescMediaBlock2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                ContentType::class,
                array(
                    'data'      => $options['data'],
                    'template'  => $options['template'],
                    'templates' => $options['templates']
                )
            )
            ->add(
                'attributes',
                EntityType::class,
                array(
                    'class'         => 'BigfootContentBundle:Attribute',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->findByType(Attribute::TYPE_PAGE);
                    },
                    'required'      => false,
                    'multiple'      => true,
                    'attr'          => array(
                        'data-placement' => 'right',
                        'data-popover'   => true,
                        'data-content'   => 'Styles applied to this content element.',
                        'data-title'     => 'Style',
                        'data-trigger'   => 'hover',
                    ),
                    'label'         => 'Style',
                )
            )
            ->add(
                'title',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'right',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the page as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add(
                'slug',
                TextType::class,
                array(
                    'required' => false,
                    'attr'     => array(
                        'data-placement' => 'right',
                        'data-popover'   => true,
                        'data-content'   => 'This value is used to generate urls. Should contain only lower case letters and the \'-\' sign.',
                        'data-title'     => 'Slug',
                        'data-trigger'   => 'hover',
                    ),
                )
            )
            ->add('seoTitle', TextType::class, array('required' => false))
            ->add('seoDescription', TextareaType::class, array('required' => false))
            ->add('description', BigfootRichtextType::class)
            ->add('media', BigfootMediaType::class)
            ->add(
                'blocks',
                BlocksType::class,
                array(
                    'label'         => false,
                    'prototype'     => true,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'entry_type'    => BlockType::class,
                    'entry_options' => array(
                        'page'       => $options['data'],
                        'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Block',
                    ),
                    'attr'          => array(
                        'class' => 'widget-blocks',
                    )
                )
            )
            ->add(
                'blocks2',
                BlocksType::class,
                array(
                    'label'         => false,
                    'prototype'     => true,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'entry_type'    => BlockType::class,
                    'entry_options' => array(
                        'page'       => $options['data'],
                        'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Block2',
                    ),
                    'attr'          => array(
                        'class' => 'widget-blocks',
                    )
                )
            )
            ->add('translation', TranslatedEntityType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Page\Template\TitleDescMediaBlock2',
                'template'   => '',
                'templates'  => ''
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_template_title_desc_media_block2';
    }
}
