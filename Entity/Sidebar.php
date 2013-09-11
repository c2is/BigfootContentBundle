<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sidebar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\SidebarRepository")
 */
class Sidebar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    private $template;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

    /**
     * @var ArrayCollection $staticcontent
     *
     * @ORM\OneToMany(targetEntity="StaticContent", mappedBy="sidebar", cascade={"persist", "remove", "merge"})
     */
    private $staticcontent;

    /**
     * @var ArrayCollection $widget
     *
     * @ORM\OneToMany(targetEntity="Widget", mappedBy="sidebar", cascade={"persist", "remove", "merge"})
     */
    private $widget;

    public function __toString() {
        return $this->title;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Sidebar
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Sidebar
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    
        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Sidebar
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->staticcontent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->widget = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add staticcontent
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent
     * @return Sidebar
     */
    public function addStaticcontent(\Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent)
    {
        $this->staticcontent[] = $staticcontent;

        return $this;
    }

    /**
     * Remove staticcontent
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent
     */
    public function removeStaticcontent(\Bigfoot\Bundle\ContentBundle\Entity\StaticContent $staticcontent)
    {
        $this->staticcontent->removeElement($staticcontent);
    }

    /**
     * Get staticcontent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStaticcontent()
    {
        return $this->staticcontent;
    }

    /**
     *
     * Get Block
     *
     * @return ArrayCollection
     */
    public function getBlock()
    {
        $tabBlock = array_merge($this->staticcontent->toArray(), $this->widget->toArray());

        Sidebar::aasort($tabBlock,"position");

        return new ArrayCollection($tabBlock);
    }

    /**
     * Sort a multi array by key
     *
     * @param $array
     * @param $key
     */
    public static function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va->{$key};
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
    }

    /**
     * Add widget
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Widget $widget
     * @return Sidebar
     */
    public function addWidget(\Bigfoot\Bundle\ContentBundle\Entity\Widget $widget)
    {
        $this->widget[] = $widget;

        return $this;
    }

    /**
     * Remove widget
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Widget $widget
     */
    public function removeWidget(\Bigfoot\Bundle\ContentBundle\Entity\Widget $widget)
    {
        $this->widget->removeElement($widget);
    }

    /**
     * Get widget
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWidget()
    {
        return $this->widget;
    }
}
