<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Widget;
use Bigfoot\Bundle\ContentBundle\Entity\StaticContent;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Bigfoot\Bundle\ContentBundle\Form\WidgetType;
use Bigfoot\Bundle\ContentBundle\Form\StaticContentType;

use Exception;


/**
 * Content controller.
 *
 * @Route("/")
 */
class ContentController extends Controller
{

    /**
     * Display Dashboard
     * @Route("/content/dashboard/", name="admin_dashboard")
     * @Method("GET")
     * @Template()
     */
    public function displayDashBoardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $widgetList = array();
        $sidebarList = array();
        $widgetsConfig = $this->container->getParameter('bigfoot_content.widgets');

        foreach ($widgetsConfig as $widgetConf) {
            if (class_exists($widgetConf)) {
                $tmpObject = new $widgetConf;
                $widgetList[] = array(
                    'label'         => $tmpObject->getLabel(),
                    'name'          => $tmpObject->getName(),
                    'parameters'    => $tmpObject->getDefaultParameters(),
                );
            }
        }

        $staticContentList = $em->getRepository('BigfootContentBundle:StaticContent')->findAll();
        $sidebarRepo = $em->getRepository('BigfootContentBundle:Sidebar')->findAll();

        foreach ($sidebarRepo as $sidebar) {

            $tempBlock = $sidebar->getBlock();
            $formBlock = array();
            $type = '';

            foreach ($tempBlock as $block) {

                $form_name = '';

                if ($block instanceof Widget) {
                    $widget_name = $this->container->getParameter('bigfoot_content.widgets')[$block->getName()];
                    $widget = new $widget_name;
                    $formTypeName = $widget->getParametersType();
                    $widgetObject = new $formTypeName($this->container);
                    $form_name = $widgetObject->getName();
                    $tempForm = $this->createForm($widgetObject, $block);
                    $type = 'widget';
                }
                else if ($block instanceof StaticContent) {
                    $tempForm = $this->createForm(new StaticContentType($this->container), $block);
                    $type = 'staticcontent';
                }

                $formBlock[] = array(
                    'id' => $block->getId(),
                    'form' => $tempForm->createView(),
                    'type' => $type,
                    'form_name' => $form_name
                );
            }

            $sidebarList[] = array(
                'id_sidebar' => $sidebar->getId(),
                'name' => $sidebar->getTitle(),
                'formBlock' => $formBlock,
            );
        }

        return $this->render('BigfootContentBundle:Dashboard:default.html.twig', array(
            'widgetList'    => $widgetList,
            'sidebarList'   => $sidebarList,
            'staticContentList'   => $staticContentList
        ));
    }

    /**
     * Save the new block order into a sidebar
     * @Route("/content/dashboard/save_block_order", name="admin_dashboard_save_block_order")
     * @Method("GET")
     * @Template()
     */
    public function saveBlockOrderAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->get('tabIdBlock') && $request->get('tabPosition') && $request->get('typeBlock')) {
            $tabIdBlock     = $request->get('tabIdBlock');
            $tabPosition    = $request->get('tabPosition');
            $typeBlock      = $request->get('typeBlock');

            $em = $this->getDoctrine()->getManager();

            foreach ($tabIdBlock as $key => $value) {
                if ($typeBlock[$key] == 'widget') {
                    $entity = $em->getRepository('BigfootContentBundle:Widget')->findOneBy(array('id' => $tabIdBlock[$key]));
                }
                else if ($typeBlock[$key] == 'staticcontent') {
                    $entity = $em->getRepository('BigfootContentBundle:StaticContent')->findOneBy(array('id' => $tabIdBlock[$key]));
                }
                $entity->setPosition($tabPosition[$key]);
                $em->persist($entity);
            }

            $em->flush();

            return new Response();
        }
    }


    /**
     * Create dynamically a Widget block or a Static Content block
     * @Route("/content/dashboard/create_dynamic_block", name="admin_dashboard_create_dynamic_block")
     * @Method("GET")
     * @Template()
     */
    public function createDynamicBlockAction(Request $request)
    {
        if ($request->isXmlHttpRequest() && $request->get('type_block') && $request->get('id_sidebar') && $request->get('widget_name')) {

            $em = $this->getDoctrine()->getManager();

            $type_block = $request->get('type_block');
            $id_sidebar = $request->get('id_sidebar');
            $widget_name = $request->get('widget_name');

            if ($type_block == 'widget') {
                $widget_name = $this->container->getParameter('bigfoot_content.widgets')[$widget_name];
                $widgetTemp = new $widget_name;
                $entity = new Widget();

                $entity->setRoute($widgetTemp->getRoute());
                $entity->setLabel($widgetTemp->getLabel());
                $entity->setName($widgetTemp->getName());
                $entity->setParams($widgetTemp->getDefaultParameters());

                $formTypeName = $widgetTemp->getParametersType();
                $widgetObject = new $formTypeName($this->container);
                $form_name = $widgetObject->getName();
                $form   = $this->createForm($widgetObject, $entity);
                $action_path = $this->container->get('router')->generate('admin_widget_create',array('form_name' => $form_name));

            }
            else if ($type_block == 'staticcontent') {
                $id_block = $request->get('id_block');
                $entity = $em->getRepository('BigfootContentBundle:StaticContent')->findOneBy(array('id' => $id_block));
                $form   = $this->createForm(new StaticContentType($this->container), $entity);
                $action_path = $this->container->get('router')->generate('admin_staticcontent_create');
            }

            return $this->render('BigfootContentBundle:Form:dynamicform.html.twig',array(
                'form'               => $form->createView(),
                'currentSidebar'     => $id_sidebar,
                'action_path'        => $action_path,
                'method'             => 'POST'
            ));
        }

    }

    /**
     * Display a Page
     * @Route("/page/display/{page_id}/", name="content_page")
     * @Method("GET")
     * @Template()
     */
    public function displayPageAction($page_id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('BigfootContentBundle:Page')->find($page_id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return $this->render('BigfootContentBundle:Content\Page:'.$page->getTemplate(), array(
            'page' => $page,
        ));
    }

    /**
     * Display a Widget
     * @Route("/widget/display/{widget_id}/", name="content_widget")
     * @Method("GET")
     * @Template()
     */
    public function displayWidgetAction($widget_id)
    {

        $em = $this->getDoctrine()->getManager();
        $widget = $em->getRepository('BigfootContentBundle:Widget')->find($widget_id);

        if (!$widget) {
            throw $this->createNotFoundException('Unable to find Widget entity.');
        }

        $parameters = $widget->getWidgetparameter();
        $tabParameter = array();

        foreach ($parameters as $param) {
            $tabParameter[$param->getField()] = $param->getValue();
        }

        return $this->render('BigfootContentBundle:Content\Widget:'.$widget->getTemplate(), array(
            'widget' => $widget,
            'tabParameter' => $tabParameter,
        ));
    }

    /**
     * Display a Sidebar
     * @Route("/sidebar/display/{sidebar_id}/", name="content_sidebar")
     * @Method("GET")
     * @Template()
     */
    public function displaySidebarAction($sidebar_id)
    {

        $em = $this->getDoctrine()->getManager();
        $sidebar = $em->getRepository('BigfootContentBundle:Sidebar')->find($sidebar_id);

        if (!$sidebar) {
            throw $this->createNotFoundException('Unable to find Sidebar entity.');
        }

        $widgets             = $sidebar->getWidget();
        $staticcontents      = $sidebar->getStaticContent();

        foreach ($widgets as $widget) {
            $parameters = $widget->getWidgetparameter();
            $tabParameter = array();

            foreach ($parameters as $param) {
                $tabParameter[$widget->getId()] = array($param->getField() => $param->getValue());
            }
        }

        return $this->render('BigfootContentBundle:Content\Sidebar:'.$sidebar->getTemplate(), array(
            'widgets'           => $widgets,
            'tabParameter'      => $tabParameter,
            'staticcontents'    => $staticcontents,
        ));
    }

    /**
     * Display a Static Content
     * @Route("/staticcontent/display/{staticcontent_id}/", name="content_staticcontent")
     * @Method("GET")
     * @Template()
     */
    public function displayStaticContentAction($staticcontent_id)
    {

        $em = $this->getDoctrine()->getManager();
        $staticcontent = $em->getRepository('BigfootContentBundle:StaticContent')->find($staticcontent_id);

        if (!$staticcontent) {
            throw $this->createNotFoundException('Unable to find StaticContent entity.');
        }

        return $this->render('BigfootContentBundle:Content\StaticContent:'.$staticcontent->getTemplate(), array(
            'staticcontent'           => $staticcontent
        ));
    }
}