<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SidebarCategory
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\SidebarCategoryRepository")
 * @ORM\Table()
 */
class SidebarCategory
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
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Sidebar", mappedBy="sidebarCategory", cascade={"persist"})
     */
    private $sidebars;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sidebars = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;

        return $this;
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
     * @return SidebarCategory
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
     * Add Sidebar
     *
     * @param Sidebar $sidebar
     * @return SidebarCategory
     */
    public function addSidebar(Sidebar $sidebar)
    {
        $sidebar->setSidebarCategory($this);

        if (!$this->sidebars->contains($sidebar)) {
            $this->sidebars->add($sidebar);
        }

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param Sidebar $sidebar
     */
    public function removeSidebar(Sidebar $sidebar)
    {
        $this->sidebars->removeElement($sidebar);
    }

    /**
     * Get sidebars
     *
     * @return ArrayCollection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }
}
