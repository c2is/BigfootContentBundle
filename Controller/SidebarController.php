<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Form\SidebarType;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

/**
 * Sidebar controller.
 *
 * @Route("/sidebar")
 */
class SidebarController extends Controller
{

    /**
     * Lists all Sidebar entities.
     *
     * @Route("/", name="admin_sidebar")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BigfootContentBundle:Sidebar')->findAll();
        $this->container->get('bigfoot.theme')['page_content']['globalActions']->addItem(new Item('crud_add', 'Add a sidebar', 'admin_sidebar_new'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Sidebar entity.
     *
     * @Route("/", name="admin_sidebar_create")
     * @Method("POST")
     * @Template("BigfootContentBundle:Sidebar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Sidebar();
        $form = $this->createForm(new SidebarType($this->container), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dashboard'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Sidebar entity.
     *
     * @Route("/new", name="admin_sidebar_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Sidebar();
        $form   = $this->createForm(new SidebarType($this->container), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Sidebar entity.
     *
     * @Route("/{id}/edit", name="admin_sidebar_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Sidebar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $editForm = $this->createForm(new SidebarType($this->container), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Sidebar entity.
     *
     * @Route("/{id}", name="admin_sidebar_update")
     * @Method("PUT")
     * @Template("BigfootContentBundle:Sidebar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Sidebar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SidebarType($this->container), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dashboard'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Sidebar entity.
     *
     * @Route("/delete/{id}", name="admin_sidebar_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Sidebar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_dashboard'));
    }

    /**
     * Creates a form to delete a Sidebar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
