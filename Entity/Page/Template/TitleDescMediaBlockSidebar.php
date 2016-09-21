<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template\TitleDescMediaBlockSidebarType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDescMediaBlockSidebar
 *
 * @ORM\Entity
 */
class TitleDescMediaBlockSidebar extends Page
{
    /**
     * @var text
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'title_desc_media_block_sidebar';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDescMediaBlockSidebar';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDescMediaBlockSidebar
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeClass()
    {
        return TitleDescMediaBlockSidebarType::class;
    }

    public static function getTemplateName()
    {
        return 'Titre + Description + Media + Block + Sidebar';
    }
}
