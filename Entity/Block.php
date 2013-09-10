<?php
namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Block
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected $label;


    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    public $position = 1;

    /**
     * @var Sidebar $sidebar
     *
     * @ORM\ManyToOne(targetEntity="Sidebar",inversedBy="block", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="sidebar_id", referencedColumnName="id")
     */
    protected $sidebar;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    protected $template;

    /**
     * @var array
     *
     * @ORM\Column(name="params", type="array")
     */
    protected $params;

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        if (sizeof($this->params) > 0 && array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return null;
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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    /**
     * Set label
     *
     * @param string $label
     * @return Widget
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return integer
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set sidebar
     *
     * @param \Bigfoot\Bundle\ContentBundle\Entity\Sidebar $sidebar
     * @return Widget
     */
    public function setSidebar(\Bigfoot\Bundle\ContentBundle\Entity\Sidebar $sidebar = null)
    {
        $this->sidebar = $sidebar;

        return $this;
    }

    /**
     * Get sidebar
     *
     * @return \Bigfoot\Bundle\ContentBundle\Entity\Sidebar
     */
    public function getSidebar()
    {
        return $this->sidebar;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Widget
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
     * @return StaticContent
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
     * Set Parameters
     */
    public function setParams($params)
    {
        $this->params= $params;

        return $this;
    }

    /**
     * Get parameters
     *
     */
    public function getParams()
    {
        return $this->params;
    }
}
