<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Block\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Attribute;
use Bigfoot\Bundle\ContentBundle\Form\Type\ContentType;
use Bigfoot\Bundle\CoreBundle\Form\Type\BigfootRichtextType;
use Bigfoot\Bundle\CoreBundle\Form\Type\TranslatedEntityType;
use Bigfoot\Bundle\MediaBundle\Form\Type\BigfootMediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class Title2Desc2Media2Type extends AbstractType
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
                    'class'     => 'BigfootContentBundle:Attribute',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->findByType(Attribute::TYPE_BLOCK);
                    },
                    'required'  => false,
                    'multiple'  => true,
                    'attr'      => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'Styles applied to this content element.',
                        'data-title'     => 'Style',
                        'data-trigger'   => 'hover',
                    ),
                    'label' => 'Style',
                )
            )
            ->add(
                'title',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the block as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add('description', BigfootRichtextType::class)
            ->add(
                'title2',
                TextType::class,
                array(
                    'attr' => array(
                        'data-placement' => 'bottom',
                        'data-popover'   => true,
                        'data-content'   => 'This is the title of the block as displayed to the web user.',
                        'data-title'     => 'Title',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'right'
                    )
                )
            )
            ->add('description2', BigfootRichtextType::class)
            ->add('media', BigfootMediaType::class)
            ->add('media2', BigfootMediaType::class)
            ->add('action', TextType::class, array('required' => false))
            ->add('translation', TranslatedEntityType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block\Template\Title2Desc2Media2',
                'template'   => '',
                'templates'  => '',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_block_template_title2_desc2_media2';
    }
}
