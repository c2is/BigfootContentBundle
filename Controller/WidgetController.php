<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bigfoot\Bundle\ContentBundle\Entity\Widget;
use Bigfoot\Bundle\ContentBundle\Form\WidgetType;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

/**
 * Widget controller.
 *
 * @Route("/widget")
 */
class WidgetController extends Controller
{

    /**
     * Lists all Widget entities.
     *
     * @Route("/", name="admin_widget")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BigfootContentBundle:Widget')->findAll();
        $this->container->get('bigfoot.theme')['page_content']['globalActions']->addItem(new Item('crud_add', 'Add a widget', 'admin_widget_new'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Widget entity.
     *
     * @Route("/{form_name}/", name="admin_widget_create")
     * @Method("POST")
     * @Template("BigfootContentBundle:Widget:new.html.twig")
     */
    public function createAction(Request $request,$form_name)
    {

        $entity  = new Widget();
        $widget_name = $this->container->getParameter('bigfoot_content.widgets')[$request->get($form_name)['name']];
        $widget = new $widget_name;
        $formTypeName = $widget->getParametersType();
        $form = $this->createForm(new $formTypeName($this->container), $entity);
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
     * Displays a form to create a new Widget entity.
     *
     * @Route("/new/", name="admin_widget_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Widget();
        $form   = $this->createForm(new WidgetType($this->container), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Widget entity.
     *
     * @Route("/{id}/edit", name="admin_widget_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Widget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $editForm = $this->createForm(new WidgetType($this->container), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Widget entity.
     *
     * @Route("/{id}/{form_name}", name="admin_widget_update")
     * @Method("PUT")
     * @Template("BigfootContentBundle:Widget:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $form_name)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Widget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $widget_name = $this->container->getParameter('bigfoot_content.widgets')[$request->get($form_name)['name']];
        $widget = new $widget_name;
        $formTypeName = $widget->getParametersType();
        $formObject = new $formTypeName($this->container);
        $editForm = $this->createForm($formObject, $entity);
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
            'form_name'   => $formObject->getName(),
        );
    }
    /**
     * Deletes a Widget entity.
     *
     * @Route("/delete/{id}", name="admin_widget_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BigfootContentBundle:Widget')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_dashboard'));
    }

    /**
     * Creates a form to delete a Widget entity by id.
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
