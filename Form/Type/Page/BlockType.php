<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Class BlockType
 * @package Bigfoot\Bundle\ContentBundle\Form\Type\Page
 */
class BlockType extends AbstractType
{
    /** @var array */
    protected $templates;

    /**
     * @param string $templates
     */
    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'block',
                EntityType::class,
                [
                    'class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
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
    public function toStringTemplates($templates)
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
     * @return string
     */
    public function getName()
    {
        return 'admin_page_block';
    }
}
