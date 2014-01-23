<?php

namespace Bigfoot\Bundle\ContentBundle\Tests\Units\Entity;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use atoum\AtoumBundle\Test\Units;


/**
 * Class StaticContent
 * @package Bigfoot\Bundle\ContentBundle\Tests\Units\Entity
 */
class StaticContent extends Units\Test
{

    /**
     * Test Label getter/setter
     */
    public function testGetLabel()
    {
        $this
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setLabel('Test label Static Content'))
            ->string($staticcontent->getLabel())
            ->isEqualTo('Test label Static Content')
            ->isNotEqualTo('Not a label')
        ;
    }

    /**
     * Test Title getter/setter
     */
    public function testGetTitle()
    {
        $this
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setTitle('Test title Static Content'))
            ->string($staticcontent->getTitle())
            ->isEqualTo('Test title Static Content')
            ->isNotEqualTo('Not a title')
        ;
    }

    /**
     * Test Description getter/setter
     */
    public function testGetDescription()
    {
        $this
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setDescription('Test description Static Content'))
            ->string($staticcontent->getDescription())
            ->isEqualTo('Test description Static Content')
            ->isNotEqualTo('Not a description')
        ;
    }

    /**
     * Test Position getter/setter
     */
    public function testGetPosition()
    {
        $this
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setPosition(99))
            ->integer($staticcontent->getPosition())
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
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setTemplate('default.html.twig'))
            ->string($staticcontent->getTemplate())
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
            ->if($staticcontent = new \Bigfoot\Bundle\ContentBundle\Entity\StaticContent())
            ->and($staticcontent->setSidebar($sidebar))
            ->object($staticcontent->getSidebar())
                ->isInstanceOf('\Bigfoot\Bundle\ContentBundle\Entity\Sidebar')
        ;
    }
}
