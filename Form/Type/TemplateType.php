<?php

namespace Bigfoot\Bundle\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $templates = $options['data'];

        $builder
            ->add(
                'template',
                'choice',
                array(
                    'required' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choices'  => $this->toStringTemplates($templates)
                )
            );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['contentType'] = $options['contentType'];
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'contentType' => ''
            )
        );
    }

    public function toStringTemplates($templates)
    {
        $nTemplates = array();

        foreach ($templates as $key => $template) {
            foreach ($template['sub_templates'] as $subTemplates) {
                $nTemplates[$subTemplates] = $subTemplates;
            }
        }

        // var_dump($nTemplates);die();

        return $nTemplates;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_template';
    }
}
