<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Widget
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\WidgetRepository")
 */
class Widget extends Block
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255)
     */
    private $route;

    /**
     * Set name
     *
     * @param string $title
     * @return Widget
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Widget
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }
}
