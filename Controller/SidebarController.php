<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;

/**
 * Sidebar controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/sidebar")
 */
class SidebarController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_sidebar';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Sidebar';
    }

    protected function getFields()
    {
        return array(
            'id'       => 'ID',
            'template' => 'Template',
            'name'     => 'Name',
        );
    }

    /**
     * @return string
     */
    public function getRouteNameForAction($action)
    {
        if (!$action or $action == 'index') {
            return $this->getName();
        } elseif ($action == 'new') {
            return 'admin_content_template_choose';
        }

        return sprintf('%s_%s', $this->getName(), $action);
    }

    /**
     * Lists Sidebar entities.
     *
     * @Route("/", name="admin_sidebar")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * New Sidebar entity.
     *
     * @Route("/new/{template}", name="admin_sidebar_new")
     */
    public function newAction(Request $request, $template)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates')['sidebar'];
        $sidebar      = $templates[$template];
        $sidebar      = new $sidebar();
        $form      = $this->createForm('admin_sidebar_'.$template, $sidebar);
        $action    = $this->generateUrl('admin_sidebar_new', array('template' => $template));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($sidebar);

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($form, $action, $sidebar);
    }

    /**
     * Edit Sidebar entity.
     *
     * @Route("/edit/{id}", name="admin_sidebar_edit")
     */
    public function editAction(Request $request, $id)
    {
        $sidebar = $this->getRepository($this->getEntity())->find($id);

        if (!$sidebar) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $form   = $this->createForm('admin_sidebar_'.$sidebar->getSlugTemplate(), $sidebar);
        $action = $this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId()));

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($sidebar);

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($form, $action, $sidebar);
    }

    /**
     * Delete Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request, $id);
    }
}
