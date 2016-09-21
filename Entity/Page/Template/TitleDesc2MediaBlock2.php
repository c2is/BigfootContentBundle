<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template\TitleDesc2MediaBlock2Type;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDesc2MediaBlock2
 *
 * @ORM\Entity
 */
class TitleDesc2MediaBlock2 extends Page
{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description_2", type="text", nullable=true)
     */
    private $description2;

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
        return 'title_desc2_media_block2';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDesc2MediaBlock2';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDesc2MediaBlock2
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
     * Set description2
     *
     * @param string $description2
     * @return TitleDesc2MediaBlock2
     */
    public function setDescription2($description2)
    {
        $this->description2 = $description2;

        return $this;
    }

    /**
     * Get description2
     *
     * @return string
     */
    public function getDescription2()
    {
        return $this->description2;
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
        return TitleDesc2MediaBlock2Type::class;
    }

    public static function getTemplateName()
    {
        return 'Titre + 2 Descriptions + Media + 2 Blocks';
    }
}
