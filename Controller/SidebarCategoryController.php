<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\ContentBundle\Entity\SidebarCategory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Bigfoot\Bundle\CoreBundle\Crud\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * SidebarCategory controller.
 *
 * @Route("/admin/contentbundle_sidebar_category")
 */
class SidebarCategoryController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_contentbundle_sidebar_category';
    }

    /**
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:SidebarCategory';
    }

    protected function getFields()
    {
        return array('id' => 'ID', 'title' => 'Title');
    }
    /**
     * Lists all SidebarCategory entities.
     *
     * @Route("/", name="admin_contentbundle_sidebar_category")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:index.html.twig")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }
    /**
     * Creates a new SidebarCategory entity.
     *
     * @Route("/", name="admin_contentbundle_sidebar_category_create")
     * @Method("POST")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new SidebarCategory();
        $form = $this->container->get('form.factory')->create($this->getFormType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->container->get('doctrine')->getManager();
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new SidebarCategory entity.
     *
     * @Route("/new", name="admin_contentbundle_sidebar_category_new")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:new.html.twig")
     */
    public function newAction()
    {
        $arrayNew = $this->doNew();
        $arrayNew['isAjax'] = true;

        return $arrayNew;
    }

    /**
     * Displays a form to edit an existing SidebarCategory entity.
     *
     * @Route("/{id}/edit", name="admin_contentbundle_sidebar_category_edit")
     * @Method("GET")
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function editAction($id)
    {
        $arrayEdit = $this->doEdit($id);
        $arrayEdit['isAjax'] = true;

        return $arrayEdit;
    }

    /**
     * Edits an existing SidebarCategory entity.
     *
     * @Route("/{id}", name="admin_contentbundle_sidebar_category_update")
     * @Method("PUT")
     * @Template("BigfootCoreBundle:crud:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:SidebarCategory')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->container->get('form.factory')->create($this->getFormType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SidebarCategory entity.
     *
     * @Route("/delete/{id}", name="admin_contentbundle_sidebar_category_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('BigfootContentBundle:SidebarCategory')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Sidebar entity.');
        }

        $em->remove($entity);
        $em->flush();

        return new RedirectResponse($this->container->get('router')->generate('admin_dashboard'));
    }
}
