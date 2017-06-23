<?php

namespace Bigfoot\Bundle\ContentBundle\Controller;

use Bigfoot\Bundle\ContentBundle\Entity\Block;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Bigfoot\Bundle\CoreBundle\Controller\CrudController;
use Bigfoot\Bundle\CoreBundle\Util\StringManager;
use Bigfoot\Bundle\ContentBundle\Entity\Page;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Block controller.
 *
 * @Cache(maxage="0", smaxage="0", public="false")
 * @Route("/block")
 */
class BlockController extends CrudController
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'admin_block';
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
        return 'BigfootContentBundle:Block';
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

        if (method_exists($this, 'newAction')) {
            $globalActions['new'] = array(
                'label'      => 'Add',
                'route'      => 'admin_content_template_choose',
                'parameters' => array('contentType' => 'block'),
                'icon'       => 'icon-plus-sign',
            );
        }

        return $globalActions;
    }

    /**
     * Lists Block entities.
     *
     * @Route("/", name="admin_block")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        return $this->doIndex($request);
    }

    /**
     * New Block entity.
     *
     * @Route("/new/{template}", name="admin_block_new")
     */
    public function newAction(Request $request, $template)
    {
        $pTemplate = $this->getParentTemplate($template);
        $templates = $this->getTemplates('block', $pTemplate);
        $block     = $templates['class'];
        $block     = new $block();
        $block->setTemplate($template);

        $action = $this->generateUrl('admin_block_new', array('template' => $template));
        $form   = $this->createForm(
            $block->getTypeClass(),
            $block,
            array(
                'template'  => $template,
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                if ($request->isXmlHttpRequest()) {
                    $content = array(
                        'option'    => array(
                            'label' => $block->getName() . ' - ' . $block->getParentTemplate(),
                            'value' => $block->getId()
                        )
                    );

                    return $this->renderAjax('new_block', 'Block created!', $content);
                }

                $this->addSuccessFlash(
                    'Block successfully added!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                        'label' => 'Block successfully added!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            } else {
                if ($request->isXmlHttpRequest()) {
                    return $this->renderAjax(false, 'Error during addition!', $this->renderForm($request, $form, $action, $block)->getContent());
                }
            }
        }

        return $this->renderForm($request, $form, $action, $block);
    }

    /**
     * Edit Block entity.
     *
     * @Route("/edit/{id}", name="admin_block_edit", options={"expose"=true})
     */
    public function editAction(Request $request, $id)
    {
        $block = $this->getRepository($this->getEntity())->find($id);

        if (!$block) {
            throw new NotFoundHttpException('Unable to find block entity.');
        }

        $templates = $this->getTemplates('block', $block->getParentTemplate());
        $action    = $this->generateUrl('admin_block_edit', array('id' => $block->getId()));

        $form = $this->createForm(
            $block->getTypeClass(),
            $block,
            array(
                'template'  => $block->getSlugTemplate(),
                'templates' => $templates
            )
        );

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->persistAndFlush($block);

                if ($request->isXmlHttpRequest()) {
                    $content = array(
                        'option'    => array(
                            'id'    => $block->getId(),
                            'label' => $block->getName() . ' - ' . $block->getParentTemplate(),
                        )
                    );

                    return $this->renderAjax('edit_block', 'Block edited!', $content);
                }

                $this->addSuccessFlash(
                    'Block successfully updated!',
                    array(
                        'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                        'label' => 'Block successfully updated!'
                    )
                );

                return $this->redirect($this->generateUrl('admin_block_edit', array('id' => $block->getId())));
            }
        }

        return $this->renderForm($request, $form, $action, $block);
    }

    /**
     * Delete Block entity.
     *
     * @Route("/delete/{id}", name="admin_block_delete")
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
                'Block successfully deleted!',
                array(
                    'route' => $this->generateUrl('admin_content_template_choose', array('contentType' => 'block')),
                    'label' => 'Block successfully deleted!'
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

    public function getTemplates($contentType, $parent)
    {
        $templates = $this->container->getParameter('bigfoot_content.templates.' . $contentType);

        return $templates[$parent];
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        $blockMetadatas   = $this->getEntityManager()->getClassMetadata(Block::class);
        $discriminatorMap = $blockMetadatas->discriminatorMap;
        foreach ($discriminatorMap as &$class) {
            if (method_exists($class, 'getTemplateName')) {
                $class = call_user_func([$class, 'getTemplateName']);
            }
        }

        return [
            'name' => [
                'name'        => 'name',
                'type'        => 'search',
                'placeholder' => 'Nom de la page',
                'options'     => [
                    'entity'     => $this->getEntity(),
                    'properties' => array('name')
                ]
            ],
            'type' => [
                'name'        => 'type',
                'type'        => 'repositoryMethod',
                'placeholder' => 'Template',
                'options'     => [
                    'method'     => 'findByInstanceOf',
                    'entity'     => $this->getEntity(),
                    'properties' => array('name'),
                    'choices'    => array_flip($discriminatorMap)
                ]
            ],
        ];
    }
}
