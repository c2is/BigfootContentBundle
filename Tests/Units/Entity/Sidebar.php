<?php

namespace Bigfoot\Bundle\ContentBundle\Tests\Units\Entity;

use Symfony\Component\DependencyInjection\Container;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use atoum\AtoumBundle\Test\Units;


/**
 * Class Sidebar
 * @package Bigfoot\Bundle\ContentBundle\Tests\Units\Entity
 */
class Sidebar extends Units\Test
{

    /**
     * Test Title getter/setter
     */
    public function testGetTitle()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setTitle('Test sidebar'))
            ->string($sidebar->getTitle())
            ->isEqualTo('Test sidebar')
            ->isNotEqualTo('Not a title')
        ;
    }

    /**
     * Test Template getter/setter
     */
    public function testGetTemplate()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setTemplate('default.html.twig'))
            ->string($sidebar->getTemplate())
            ->isEqualTo('default.html.twig')
        ;
    }

    /**
     * Test Active getter/setter
     */
    public function testGetActive()
    {
        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->setActive(true))
            ->boolean($sidebar->getActive())
            ->isEqualTo(true)
            ->isNotEqualTo(false)
        ;
    }

    /**
     * Test StaticContent getter/setter
     */
    public function testGetStaticContent()
    {
        $staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent();

        $staticcontent
            ->setLabel('Test label Static Content')
            ->setDescription('Test description Static Content')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addStaticcontent($staticcontent))
            ->boolean($sidebar->getStaticcontent()->contains($staticcontent))
            ->isEqualTo(true)
        ;
    }

    /**
     * Test Widget getter/setter
     */
    public function testGetWidget()
    {
        $widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget();

        $widget
            ->setLabel('Test label Widget')
            ->setName('Test name Widget')
            ->setRoute('route_test')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addWidget($widget))
            ->boolean($sidebar->getWidget()->contains($widget))
            ->isEqualTo(true)
        ;
    }

    /**
     * Test removal Widget
     */
    public function testRemoveWidget()
    {
        $widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget();

        $widget
            ->setLabel('Test label Widget')
            ->setName('Test name Widget')
            ->setRoute('route_test')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addWidget($widget))
            ->and($sidebar->removeWidget($widget))
            ->boolean($sidebar->getWidget()->contains($widget))
            ->isEqualTo(false)
        ;
    }

    /**
     * Test removal Static Content
     */
    public function testRemoveStaticContent()
    {
        $staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent();

        $staticcontent
            ->setLabel('Test label Static Content')
            ->setDescription('Test description Static Content')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $this
            ->if($sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar())
            ->and($sidebar->addStaticcontent($staticcontent))
            ->and($sidebar->removeStaticcontent($staticcontent))
            ->boolean($sidebar->getStaticcontent()->contains($staticcontent))
            ->isEqualTo(false)
        ;
    }

    /**
     * Test blocks into Sidebar
     */
    public function testGetBlock()
    {
        $staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent();

        $staticcontent
            ->setLabel('Test label Static Content')
            ->setDescription('Test description Static Content')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $widget = new \Bigfoot\Bundle\ContentBundle\Entity\Widget();

        $widget
            ->setLabel('Test label Widget')
            ->setName('Test name Widget')
            ->setRoute('route_test')
            ->setPosition(99)
            ->setTemplate('default.html.twig')
        ;

        $sidebar = new \Bigfoot\Bundle\ContentBundle\Entity\Sidebar();
        $sidebar->addStaticcontent($staticcontent);
        $sidebar->addWidget($widget);
        $blocks = $sidebar->getBlock()->toArray();

        $this
            ->array($blocks)
            ->hasSize(2)
            ->object($blocks[0])
            ->isInstanceOf('\Bigfoot\Bundle\ContentBundle\Entity\StaticContent')
            ->object($blocks[1])
            ->isInstanceOf('\Bigfoot\Bundle\ContentBundle\Entity\Widget')
        ;

        $sidebar->removeWidget($blocks[1]);
        $blocks = $sidebar->getBlock()->toArray();

        $this
            ->array($blocks)
            ->hasSize(1)
            ->object($blocks[0])
            ->isInstanceOf('\Bigfoot\Bundle\ContentBundle\Entity\StaticContent')
        ;
    }
}
