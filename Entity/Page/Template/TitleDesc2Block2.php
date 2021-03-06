<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page\Template;

use Bigfoot\Bundle\ContentBundle\Form\Type\Page\Template\TitleDesc2Block2Type;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Bigfoot\Bundle\ContentBundle\Entity\Page;

/**
 * TitleDesc2Block2
 *
 * @ORM\Entity
 */
class TitleDesc2Block2 extends Page
{
    /**
     * @var text
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var text
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description_2", type="text", nullable=true)
     */
    private $description2;

    /**
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'title_desc2_block2';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'TitleDesc2Block2';
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TitleDesc2Block2
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
     * @return TitleDesc2Block2
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
     * {@inheritDoc}
     */
    public function getTypeClass()
    {
        return TitleDesc2Block2Type::class;
    }

    public static function getTemplateName()
    {
        return 'Titre + 2 Descriptions + 2 Blocks';
    }
}