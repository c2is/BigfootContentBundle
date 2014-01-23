<?php

namespace Bigfoot\Bundle\ContentBundle\Tests\Units\Entity;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use atoum\AtoumBundle\Test\Units;


/**
 * Class Widget
 * @package Bigfoot\Bundle\ContentBundle\Tests\Units\Entity
 */
class Widget extends Units\Test
{

    /**
     * Test Label getter/setter
     */
    public function testGetLabel()
    {
        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setLabel('Test label Widget'))
            ->string($widget->getLabel())
            ->isEqualTo('Test label Widget')
            ->isNotEqualTo('Not a label')
        ;
    }

    /**
     * Test Name getter/setter
     */
    public function testGetName()
    {
        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setName('Test name Widget'))
            ->string($widget->getName())
            ->isEqualTo('Test name Widget')
            ->isNotEqualTo('Not a name')
        ;
    }

    /**
     * Test Route getter/setter
     */
    public function testGetRoute()
    {
        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setRoute('route_test'))
            ->string($widget->getRoute())
            ->isEqualTo('route_test')
            ->isNotEqualTo('Not a route')
        ;
    }

    /**
     * Test Position getter/setter
     */
    public function testGetPosition()
    {
        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setPosition(99))
            ->integer($widget->getPosition())
            ->isEqualTo(99)
            ->isNotEqualTo(100)
        ;
    }

    /**
     * Test Template getter/setter
     */
    public function testGetTemplate()
    {
        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setTemplate('default.html.twig'))
            ->string($widget->getTemplate())
            ->isEqualTo('default.html.twig')
            ->isNotEqualTo('Not a template')
        ;
    }

    /**
     * Test Sidebar getter/setter
     */
    public function testGetSidebar()
    {
        $sidebar =  new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar();

        $sidebar
            ->setTitle('Test Sidebar')
            ->setTemplate('default.html.twig')
            ->setActive(1)
        ;

        $this
            ->if($widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget())
            ->and($widget->setSidebar($sidebar))
            ->object($widget->getSidebar())
                ->isInstanceOf('\Bigfoot\Bundle\ContentBundle\Entity\Sidebar')
        ;
    }
}
