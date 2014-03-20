<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\BaseController;

/**
 * Template controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/content/template")
 */
class TemplateController extends BaseController
{
    /**
     * Choose template.
     *
     * @Route("/choose/{contentType}", name="admin_content_template_choose")
     * @Template()
     */
    public function chooseAction(Request $request, $contentType = null)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.'.$contentType);
        $form      = $this->createForm('admin_template', null, array('data' => $templates, 'contentType' => $contentType));
        $content   = array(
            'form_method' => 'POST',
            'form_title'  => $this->getTranslator()->trans('%entity% creation', array('%entity%' => ucfirst($contentType))),
            'form_action' => $this->generateUrl('admin_content_template_choose', array('contentType' => $contentType)),
            'form_submit' => 'Submit',
            'form_cancel' => 'admin_'.$contentType,
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $template = $form['template']->getData();

                if ($request->isXmlHttpRequest()) {
                    return $this->renderAjax(true, 'Template selected!', $this->renderForm($contentType, $template)->getContent());
                }

                return $this->redirect($this->generateUrl('admin_'.$contentType.'_new', array('template' => $template)));
            } else {
                if ($request->isXmlHttpRequest()) {
                    $content['form'] = $form->createView();
                    $content         = $this->renderView('BigfootContentBundle:Template:choose.html.twig', $content);

                    return $this->renderAjax(false, 'Select a template!', $content);
                }
            }
        }

        $content['form'] = $form->createView();

        return $content;
    }

    public function getContentForm($contentType, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates($contentType, $pTemplate);
        $content   = $templates['class'];
        $content   = new $content();
        $content->setTemplate($contentType, $template);

        return array(
            'content' => $content,
            'form'    => $this->createForm(
                'admin_'.$contentType.'_template_'.$pTemplate,
                $content,
                array(
                    'template'  => $template,
                    'templates' => $templates
                )
            )
        );
    }

    public function getParentTemplate($template)
    {
        $values = explode('_', $template);
        $end    = call_user_func('end', array_values($values));

        return str_replace('_'.$end, '', $template);
    }

    public function getTemplates($contentType, $parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.'.$contentType);

        return $templates[$parent];
    }

    public function renderForm($contentType, $template)
    {
        $contentForm = $this->getContentForm($contentType, $template);
        $action      = $this->generateUrl('admin_'.$contentType.'_new', array('template' => $template));

        return $this->render(
            'BigfootContentBundle:'.ucfirst($contentType).':edit.html.twig',
            array(
                'form'        => $contentForm['form']->createView(),
                'form_method' => 'POST',
                'form_title'  => $this->getTranslator()->trans($contentType.' creation'),
                'form_action' => $action,
                'form_submit' => 'Submit',
                'entity'      => $contentForm['content'],
                'layout'      => $this->getRequest()->query->get('layout') ?: '',
            )
        );
    }
}
