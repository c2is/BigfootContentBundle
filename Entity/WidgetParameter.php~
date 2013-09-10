<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WidgetParameter
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\WidgetParameterRepository")
 */
class WidgetParameter
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
     * @ORM\Column(name="field", type="string", length=255)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var Widget $widget
     *
     * @ORM\ManyToOne(targetEntity="Widget", inversedBy="widgetparameter", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="widget_id", referencedColumnName="id")
     */
    private $widget;


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
     * Set field
     *
     * @param string $field
     * @return WidgetParameter
     */
    public function setField($field)
    {
        $this->field = $field;
    
        return $this;
    }

    /**
     * Get field
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return WidgetParameter
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set widget
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Widget $widget
     * @return WidgetParameter
     */
    public function setWidget(\Bigfoot\Bundle\ContentBundle\Entity\Widget $widget = null)
    {
        $this->widget = $widget;
    
        return $this;
    }

    /**
     * Get widget
     *
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Widget 
     */
    public function getWidget()
    {
        return $this->widget;
    }
}