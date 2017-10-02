<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Model\Content;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 as PageBlock3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 as PageBlock4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 as PageBlock5;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 as PageSidebar2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 as PageSidebar3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 as PageSidebar4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 as PageSidebar5;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @Gedmo\TranslationEntity(class="Bigfoot\Bundle\ContentBundle\Entity\PageTranslation")
 * @ORM\Table(name="bigfoot_content_page")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\PageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Page extends Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=255, nullable=true)
     */
    private $uniqueId;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    protected $seoTitle;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="seo_description", type="text", nullable=true)
     */
    protected $seoDescription;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $blocks;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $blocks2;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block3", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $blocks3;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block4", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $blocks4;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block5", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $blocks5;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $sidebars;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $sidebars2;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $sidebars3;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $sidebars4;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5", mappedBy="page", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private $sidebars5;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Attribute")
     * @ORM\JoinTable(name="bigfoot_page_attribute")
     */
    private $attributes;

    /**
     * @ORM\OneToMany(
     *   targetEntity="PageTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Construct Page
     */
    public function __construct()
    {
        $this->blocks     = new ArrayCollection();
        $this->blocks2    = new ArrayCollection();
        $this->blocks3    = new ArrayCollection();
        $this->blocks4    = new ArrayCollection();
        $this->blocks5    = new ArrayCollection();
        $this->sidebars   = new ArrayCollection();
        $this->sidebars2  = new ArrayCollection();
        $this->sidebars3  = new ArrayCollection();
        $this->sidebars4  = new ArrayCollection();
        $this->sidebars5  = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->translations = new ArrayCollection();
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
     * @return $this
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
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $seoTitle
     * @return $this
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * @param string $seoDescription
     * @return $this
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block $block
     *
     * @return $this
     */
    public function addBlock(PageBlock $block)
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks->add($block);
            $block->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block $block
     *
     * @return $this
     */
    public function removeBlock(PageBlock $block)
    {
        if ($this->blocks->contains($block)) {
            $this->blocks->removeElement($block);
            $block->setPage(null);
        }

        return $this;
    }

    /**
     * @param $blocks
     *
     * @return $this
     */
    public function setBlocks($blocks)
    {
        foreach ($this->blocks as $block) {
            $this->removeBlock($block);
        }

        foreach ($blocks as $block) {
            $this->addBlock($block);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 $block
     *
     * @return $this
     */
    public function addBlock2(PageBlock2 $block)
    {
        if (!$this->blocks2->contains($block)) {
            $this->blocks2->add($block);
            $block->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 $block
     *
     * @return $this
     */
    public function removeBlock2(PageBlock2 $block)
    {
        if ($this->blocks2->contains($block)) {
            $this->blocks2->removeElement($block);
            $block->setPage(null);
        }

        return $this;
    }

    /**
     * @param $blocks
     *
     * @return $this
     */
    public function setBlocks2($blocks)
    {
        foreach ($this->blocks2 as $block) {
            $this->removeBlock2($block);
        }

        foreach ($blocks as $block) {
            $this->addBlock2($block);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks2()
    {
        return $this->blocks2;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 $block
     *
     * @return $this
     */
    public function addBlock3(PageBlock3 $block)
    {
        if (!$this->blocks3->contains($block)) {
            $this->blocks3->add($block);
            $block->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 $block
     *
     * @return $this
     */
    public function removeBlock3(PageBlock3 $block)
    {
        if ($this->blocks3->contains($block)) {
            $this->blocks3->removeElement($block);
            $block->setPage(null);
        }

        return $this;
    }

    /**
     * @param $blocks
     *
     * @return $this
     */
    public function setBlocks3($blocks)
    {
        foreach ($this->blocks3 as $block) {
            $this->removeBlock3($block);
        }

        foreach ($blocks as $block) {
            $this->addBlock3($block);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks3()
    {
        return $this->blocks3;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 $block
     *
     * @return $this
     */
    public function addBlock4(PageBlock4 $block)
    {
        if (!$this->blocks4->contains($block)) {
            $this->blocks4->add($block);
            $block->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 $block
     *
     * @return $this
     */
    public function removeBlock4(PageBlock4 $block)
    {
        if ($this->blocks4->contains($block)) {
            $this->blocks4->removeElement($block);
            $block->setPage(null);
        }

        return $this;
    }

    /**
     * @param $blocks
     *
     * @return $this
     */
    public function setBlocks4($blocks)
    {
        foreach ($this->blocks4 as $block) {
            $this->removeBlock4($block);
        }

        foreach ($blocks as $block) {
            $this->addBlock4($block);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks4()
    {
        return $this->blocks4;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 $block
     *
     * @return $this
     */
    public function addBlock5(PageBlock5 $block)
    {
        if (!$this->blocks5->contains($block)) {
            $this->blocks5->add($block);
            $block->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 $block
     *
     * @return $this
     */
    public function removeBlock5(PageBlock5 $block)
    {
        if ($this->blocks5->contains($block)) {
            $this->blocks5->removeElement($block);
            $block->setPage(null);
        }

        return $this;
    }

    /**
     * @param $blocks
     *
     * @return $this
     */
    public function setBlocks5($blocks)
    {
        foreach ($this->blocks5 as $block) {
            $this->removeBlock5($block);
        }

        foreach ($blocks as $block) {
            $this->addBlock5($block);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Block[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getBlocks5()
    {
        return $this->blocks5;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar $sidebar
     *
     * @return $this
     */
    public function addSidebar(PageSidebar $sidebar)
    {
        if (!$this->sidebars->contains($sidebar)) {
            $this->sidebars->add($sidebar);
            $sidebar->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar $sidebar
     *
     * @return $this
     */
    public function removeSidebar(PageSidebar $sidebar)
    {
        if ($this->sidebars->contains($sidebar)) {
            $this->sidebars->removeElement($sidebar);
            $sidebar->setPage(null);
        }

        return $this;
    }

    /**
     * @param $sidebars
     *
     * @return $this
     */
    public function setSidebars($sidebars)
    {
        foreach ($this->sidebars as $sidebar) {
            $this->removeSidebar($sidebar);
        }

        foreach ($sidebars as $sidebar) {
            $this->addSidebar($sidebar);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 $sidebar
     *
     * @return $this
     */
    public function addSidebar2(PageSidebar2 $sidebar)
    {
        if (!$this->sidebars2->contains($sidebar)) {
            $this->sidebars2->add($sidebar);
            $sidebar->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 $sidebar
     *
     * @return $this
     */
    public function removeSidebar2(PageSidebar2 $sidebar)
    {
        if ($this->sidebars2->contains($sidebar)) {
            $this->sidebars2->removeElement($sidebar);
            $sidebar->setPage(null);
        }

        return $this;
    }

    /**
     * @param $sidebars
     *
     * @return $this
     */
    public function setSidebars2($sidebars)
    {
        foreach ($this->sidebars2 as $sidebar) {
            $this->removeSidebar2($sidebar);
        }

        foreach ($sidebars as $sidebar) {
            $this->addSidebar2($sidebar);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSidebars2()
    {
        return $this->sidebars2;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 $sidebar
     *
     * @return $this
     */
    public function addSidebar3(PageSidebar3 $sidebar)
    {
        if (!$this->sidebars3->contains($sidebar)) {
            $this->sidebars3->add($sidebar);
            $sidebar->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 $sidebar
     *
     * @return $this
     */
    public function removeSidebar3(PageSidebar3 $sidebar)
    {
        if ($this->sidebars3->contains($sidebar)) {
            $this->sidebars3->removeElement($sidebar);
            $sidebar->setPage(null);
        }

        return $this;
    }

    /**
     * @param $sidebars
     *
     * @return $this
     */
    public function setSidebars3($sidebars)
    {
        foreach ($this->sidebars3 as $sidebar) {
            $this->removeSidebar3($sidebar);
        }

        foreach ($sidebars as $sidebar) {
            $this->addSidebar3($sidebar);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSidebars3()
    {
        return $this->sidebars3;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 $sidebar
     *
     * @return $this
     */
    public function addSidebar4(PageSidebar4 $sidebar)
    {
        if (!$this->sidebars4->contains($sidebar)) {
            $this->sidebars4->add($sidebar);
            $sidebar->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 $sidebar
     *
     * @return $this
     */
    public function removeSidebar4(PageSidebar4 $sidebar)
    {
        if ($this->sidebars4->contains($sidebar)) {
            $this->sidebars4->removeElement($sidebar);
            $sidebar->setPage(null);
        }

        return $this;
    }

    /**
     * @param $sidebars
     *
     * @return $this
     */
    public function setSidebars4($sidebars)
    {
        foreach ($this->sidebars4 as $sidebar) {
            $this->removeSidebar4($sidebar);
        }

        foreach ($sidebars as $sidebar) {
            $this->addSidebar4($sidebar);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSidebars4()
    {
        return $this->sidebars4;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 $sidebar
     *
     * @return $this
     */
    public function addSidebar5(PageSidebar5 $sidebar)
    {
        if (!$this->sidebars5->contains($sidebar)) {
            $this->sidebars5->add($sidebar);
            $sidebar->setPage($this);
        }

        return $this;
    }

    /**
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 $sidebar
     *
     * @return $this
     */
    public function removeSidebar5(PageSidebar5 $sidebar)
    {
        if ($this->sidebars5->contains($sidebar)) {
            $this->sidebars5->removeElement($sidebar);
            $sidebar->setPage(null);
        }

        return $this;
    }

    /**
     * @param $sidebars
     *
     * @return $this
     */
    public function setSidebars5($sidebars)
    {
        foreach ($this->sidebars5 as $sidebar) {
            $this->removeSidebar5($sidebar);
        }

        foreach ($sidebars as $sidebar) {
            $this->addSidebar5($sidebar);
        }

        return $this;
    }

    /**
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getSidebars5()
    {
        return $this->sidebars5;
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function addAttribute($attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function removeAttribute($attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     * @return $this
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getArrayAttributes()
    {
        $toReturn = array();

        foreach ($this->attributes as $attribute) {
            if (!isset($toReturn[$attribute->getName()])) {
                $toReturn[$attribute->getName()] = array();
            }

            $toReturn[$attribute->getName()][] = $attribute->getValue();
        }

        return $toReturn;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param PageTranslation $t
     */
    public function addTranslation(PageTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeClass()
    {
        return null;
    }

    public static function getTemplateName()
    {
        return 'Page';
    }
}
