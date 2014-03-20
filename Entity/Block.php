<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block as SidebarBlock;

/**
 * Block
 *
 * @ORM\Table(name="bigfoot_content_block")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\BlockRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Block extends Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    protected $action;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block", mappedBy="block", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * Construct Block
     */
    public function __construct()
    {
        $this->pageBlocks  = new ArrayCollection();
        $this->pageBlocks2 = new ArrayCollection();
        $this->sidebars    = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName().' - '.$this->getParentTemplate();
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
     * Set action
     *
     * @param string $action
     * @return Block
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Add pageBlocks
     *
     * @param PageBlock $pageBlocks
     * @return Block
     */
    public function addPageBlock(PageBlock $pageBlock)
    {
        $this->pageBlocks->add($pageBlock);

        return $this;
    }

    /**
     * Remove pageBlocks
     *
     * @param PageBlock $pageBlocks
     */
    public function removePageBlock(PageBlock $pageBlock)
    {
        $this->pageBlocks->removeElement($pageBlock);

        return $this;
    }

    /**
     * Get pageBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks()
    {
        return $this->pageBlocks;
    }

    /**
     * Add pageBlocks2
     *
     * @param PageBlock $pageBlocks2
     * @return Block
     */
    public function addPageBlock2(PageBlock2 $pageBlock2)
    {
        $this->pageBlocks2->add($pageBlock2);

        return $this;
    }

    /**
     * Remove pageBlocks2
     *
     * @param PageBlock $pageBlocks2
     */
    public function removePageBlock2(PageBlock2 $pageBlock2)
    {
        $this->pageBlocks2->removeElement($pageBlock2);

        return $this;
    }

    /**
     * Get pageBlocks2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks2()
    {
        return $this->pageBlocks2;
    }

    /**
     * Add sidebar
     *
     * @param SidebarBlock $sidebar
     * @return Block
     */
    public function addSidebar(SidebarBlock $sidebar)
    {
        $this->sidebars->add($sidebar);

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param SidebarBlock $sidebar
     */
    public function removeSidebar(SidebarBlock $sidebar)
    {
        $this->sidebars->removeElement($sidebar);

        return $this;
    }

    /**
     * Get sidebars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }
}