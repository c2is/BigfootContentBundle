<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type\Page;

use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BlockType extends AbstractType
{
    /** @var array */
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
                    'class' => 'Bigfoot\Bundle\ContentBundle\Entity\Block',
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
            )
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['templates'] = $this->templates;
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var ChoiceView[] $choices */
        $choices = $view->children['block']->vars['choices'];
        foreach ($choices as $choice) {
            if (null !== ($blockType = $this->getBlockTypeBlockClass(get_class($choice->data)))) {
                $choice->attr = ['data-block-type' => $blockType];
            }
        }
    }

    private function getBlockTypeBlockClass($class)
    {
        foreach ($this->templates as $k => $v) {
            if ($v['class'] == $class) {
                return $k;
            }
        }

        return null;
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'page' => null,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_page_block';
    }
}
