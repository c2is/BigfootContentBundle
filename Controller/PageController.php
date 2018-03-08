<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Event\FormEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Page controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/page")
 */
class PageController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_page';
    }

    /**
     * @return string
     */
    protected function getNewUrl()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Page';
    }

    protected function getFields()
    {
        return array(
            'id'       => array(
                'label' => 'ID',
            ),
            'template' => array(
                'label' => 'Template',
            ),
            'name'     => array(
                'label' => 'Name',
            ),
        );
    }

    public function getFormTemplate()
    {
        return $this->getEntity() . ':edit.html.twig';
    }

    /**
     * Return array of allowed global actions
     *
     * @return array
     */
    protected function getGlobalActions()
    {
        $globalActions = array();

        if (method_exists($this, 'chooseAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'page'),
                'icon'       => 'icon-plus-sign',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Page entities.
     *
     * @Route("/", name="admin_page")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        return $this->doIndex($request);
    }

    /**
     * New Page entity.
     *
     * @Route("/new/{template}", name="admin_page_new")
     */
    public function chooseAction(Request $request, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates($pTemplate);
        $page      = $templates['class'];
        $page      = new $page();
        $page->setTemplate($template);
        $action = $this->generateUrl('admin_page_new', array('template' => $template));
        $form   = $this->createForm(
            $page->getTypeClass(),
            $page,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        $this->getEventDispatcher()->dispatch(FormEvent::CREATE, new GenericEvent($form));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($page);

                $this->addSuccessFlash(
                    'Page successfully added!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                        'label' => 'Page successfully added!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($request, $form, $action, $page);
    }

    /**
     * Edit Page entity.
     *
     * @Route("/edit/{id}", name="admin_page_edit")
     */
    public function editAction(Request $request, $id)
    {
        /** @var Page $page */
        $page = $this->getRepository($this->getEntity())->find($id);

        if (!$page) {
            throw new NotFoundHttpException('Unable to find Page entity.');
        }
        $templates = $this->getTemplates($page->getParentTemplate());
        $action    = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));

        $form = $this->createForm(
            $page->getTypeClass(),
            $page,
            array(
                'template'  => $page->getSlugTemplate(),
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($page);

                $this->get('event_dispatcher')->dispatch(CrudController::POST_EDIT, new GenericEvent($page));

                $this->addSuccessFlash(
                    'Page successfully updated!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                        'label' => 'Page successfully updated!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $page->getId())));
            }
        }

        return $this->renderForm($request, $form, $action, $page);
    }

    /**
     * Delete Page entity.
     *
     * @Route("/delete/{id}", name="admin_page_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getRepository($this->getEntity())->find($id);

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('Unable to find %s entity.', $this->getEntity()));
        }

        $this->removeAndFlush($entity);

        if (!$request->isXmlHttpRequest()) {
            $this->addSuccessFlash(
                'Page successfully deleted!',
                array(
                    'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'page')),
                    'label' => 'Page successfully deleted!'
                )
            );


            return $this->redirect($this->generateUrl($this->getRouteNameForAction('index')));
        }

        return $this->doDelete($request, $id);
    }

    public function getParentTemplate($template)
    {
        $values = explode('_', $template);
        $end    = call_user_func('end', array_values($values));
        return str_replace('_' . $end, '', $template);
    }

    public function getTemplates($parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.page');

        return $templates[$parent];
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        $pageMetadatas    = $this->getEntityManager()->getClassMetadata(Page::class);
        $discriminatorMap = $pageMetadatas->discriminatorMap;
        foreach ($discriminatorMap as &$class) {
            if (method_exists($class, 'getTemplateName')) {
                $class = call_user_func([$class, 'getTemplateName']);
            }
        }

        return [
            'title' => [
                'name'        => 'title',
                'type'        => 'search',
                'placeholder' => 'Nom de la page',
                'options'     => [
                    'entity'     => $this->getEntity(),
                    'properties' => array('title')
                ]
            ],
            'type'  => [
                'name'        => 'type',
                'type'        => 'repositoryMethod',
                'placeholder' => 'Template',
                'options'     => [
                    'method'     => 'findByInstanceOf',
                    'entity'     => $this->getEntity(),
                    'properties' => array('title'),
                    'choices'    => array_flip($discriminatorMap)
                ]
            ],
        ];
    }
}
