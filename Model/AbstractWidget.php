<?php
namespace Bigfoot\Bundle\ContentBundle\Model;

/**
 * Abstract class AbstractWidget
 *
 * All Widget class have to extend this class in order to be listed in the dashboard
 *
 * @package Bigfoot\Bundle\ContentBundle\Model
 */
abstract class AbstractWidget
{
    abstract protected function getLabel();

    abstract protected function getName();

    abstract protected function getDefaultParameters();

    abstract protected function getRoute();

    abstract protected function getParametersType();
}
