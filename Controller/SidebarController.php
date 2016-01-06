<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Doctrine\Common\Collections\ArrayCollection;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Util\StringManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    protected function getNewUrl()
    {
        return '';
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
        return $this->getEntity().':edit.html.twig';
    }

    /**
     * Return array of allowed global actions
     *
     * @return array
     */
    protected function getGlobalActions()
    {
        $globalActions = array();

        if (method_exists($this, 'newAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'sidebar'),
                'icon'       => 'icon-plus-sign',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Sidebar entities.
     *
     * @Route("/", name="admin_sidebar")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        return $this->doIndex($request);
    }

    /**
     * New Sidebar entity.
     *
     * @Route("/new/{template}", name="admin_sidebar_new")
     */
    public function newAction(Request $request, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates($pTemplate);
        $sidebar   = $templates['class'];
        $sidebar   = new $sidebar();
        $sidebar->setTemplate($template);

        $action = $this->generateUrl('admin_sidebar_new', array('template' => $template));
        $form   = $this->createForm(
            'admin_sidebar_template_'.$pTemplate,
            $sidebar,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($sidebar);

                $this->addSuccessFlash(
                    'Sidebar successfully added!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'sidebar')),
                        'label' => 'Sidebar successfully added!',
                    )
                );

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($request, $form, $action, $sidebar);
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

        $templates = $this->getTemplates($sidebar->getParentTemplate());
        $action    = $this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId()));
        $form      = $this->createForm(
            'admin_sidebar_template_'.$sidebar->getParentTemplate(),
            $sidebar,
            array(
                'template'  => $sidebar->getSlugTemplate(),
                'templates' => $templates
            )
        );

        $dbBlocks = new ArrayCollection();

        foreach ($sidebar->getBlocks() as $block) {
            $dbBlocks->add($block);
        }

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                foreach ($dbBlocks as $block) {
                    if ($sidebar->getBlocks()->contains($block) === false) {
                        $sidebar->getBlocks()->removeElement($block);
                        $this->getEntityManager()->remove($block);
                    }
                }

                $this->persistAndFlush($sidebar);

                $this->addSuccessFlash(
                    'Sidebar successfully updated!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'sidebar')),
                        'label' => 'Sidebar successfully updated!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_sidebar_edit', array('id' => $sidebar->getId())));
            }
        }

        return $this->renderForm($request, $form, $action, $sidebar);
    }

    /**
     * Delete Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
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
                'Sidebar successfully deleted!',
                array(
                    'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'sidebar')),
                    'label' => 'Sidebar successfully deleted!',
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

        return str_replace('_'.$end, '', $template);
    }

    public function getTemplates($parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.sidebar');

        return $templates[$parent];
    }
}
