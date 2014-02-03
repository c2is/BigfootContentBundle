<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;
use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/admin/page")
 */
class PageController extends CrudController
{

    /**
     * Used to generate route names.
     * The helper method of this class will use routes named after this name.
     * This means if you extend this class and use its helper methods, if getName() returns 'my_controller', you must implement a route named 'my_controller'.
     *
     * @return string
     */
    protected function getName()
    {
        return 'admin_page';
    }

    /**
     * Must return the entity full name (eg. BigfootCoreBundle:Tag).
     *
     * @return string
     */
    protected function getEntity()
    {
        return 'BigfootContentBundle:Page';
    }

    /**
     * Must return an associative array field name => field label.
     *
     * @return array
     */
    protected function getFields()
    {
        return array(
            'id'        => 'ID',
            'title'     => 'Title',
            'template'  => 'Template',
            'active'    => 'Active',
        );
    }

    protected function getFormType()
    {
        return 'bigfoot_bundle_contentbundle_pagetype';
    }

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_page")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->doIndex();
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="admin_page_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        return $this->doCreate($request);
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="admin_page_new")
     * @Method("GET")
     */
    public function newAction()
    {
        return $this->doNew();
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        return $this->doEdit($id);
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="admin_page_update")
     * @Method("GET|POST|PUT")
     */
    public function updateAction(Request $request, $id)
    {
        return $this->doUpdate($request,$id);
    }
    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}/delete", name="admin_page_delete")
     * @Method("GET|DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->doDelete($request,$id);
    }

    /**
     * Creates a form to delete a Page entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($id)
    {
        return $this->container->get('form.factory')->createBuilder('form', array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
