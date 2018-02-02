<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Sidebar;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BlockType extends AbstractType
{
    protected $templates;

    /**
     * Construct Block Type
     *
     * @param string $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'block',
                EntityType::class,
                array(
                    'class'         => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('b')->orderBy('b.name', 'ASC');
                    }
                )
            )
            ->add('position')
            ->add(
                'template',
                ChoiceType::class,
                array(
                    'required'          => true,
                    'expanded'          => true,
                    'multiple'          => false,
                    'choices_as_values' => true,
                    'choices'           => array_flip($this->toStringTemplates($this->templates))
                )
            );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $data = $event->getData();
                $data->setSidebar($options['sidebar']);
            }
        );
    }

    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates => $label) {
                $nTemplates[$key . '/' . $subTemplates] = $label;
            }
        }

        asort($nTemplates);

        return $nTemplates;
    }

    /**
     * @param \Symfony\Component\Form\FormView      $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array                                 $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['templates'] = $this->templates;
    }

    /**
     * @param \Symfony\Component\Form\FormView      $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array                                 $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var \Symfony\Component\Form\ChoiceList\View\ChoiceView[] $choices */
        $choices = $view->children['block']->vars['choices'];

        foreach ($choices as $choice) {
            if (null !== ($blockType = $this->getBlockTypeBlockClass(get_class($choice->data)))) {
                $choice->attr = ['data-block-type' => $blockType];
            }
        }
    }

    /**
     * @param $class
     *
     * @return int|null|string
     */
    private function getBlockTypeBlockClass($class)
    {
        foreach ($this->templates as $k => $v) {
            if ($v['class'] == $class) {
                return $k;
            }
        }

        return null;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'sidebar' => null
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_sidebar_block';
    }
}
