<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bigfoot\Bundle\ContentBundle\Entity\StaticContent;
use Bigfoot\Bundle\ContentBundle\Form\StaticContentType;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

/**
 * StaticContent controller.
 *
 * @Route("/staticcontent")
 */
class StaticContentController extends Controller
{

    /**
     * Lists all StaticContent entities.
     *
     * @Route("/", name="admin_staticcontent")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BigfootContentBundle:StaticContent')->findAll();
        $this->container->get('bigfoot.theme')['page_content']['globalActions']->addItem(new Item('crud_add', 'Add a static content', 'admin_staticcontent_new'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new StaticContent entity.
     *
     * @Route("/", name="admin_staticcontent_create")
     * @Method("POST")
     * @Template("BigfootContentBundle:StaticContent:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new StaticContent();
        $form = $this->createForm(new StaticContentType($this->container), $entity);
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
     * Displays a form to create a new StaticContent entity.
     *
     * @Route("/new", name="admin_staticcontent_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StaticContent();
        $form   = $this->createForm(new StaticContentType($this->container), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StaticContent entity.
     *
     * @Route("/{id}/edit", name="admin_staticcontent_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $editForm = $this->createForm(new StaticContentType($this->container), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing StaticContent entity.
     *
     * @Route("/{id}", name="admin_staticcontent_update")
     * @Method("PUT")
     * @Template("BigfootContentBundle:StaticContent:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new StaticContentType($this->container), $entity);
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
     * Deletes a StaticContent entity.
     *
     * @Route("/delete/{id}", name="admin_staticcontent_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:StaticContent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_dashboard'));
    }

    /**
     * Creates a form to delete a StaticContent entity by id.
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
