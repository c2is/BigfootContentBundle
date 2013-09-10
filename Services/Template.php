<?php

namespace Bigfoot\Bundle\ContentBundle\Services;

use Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Template class
 *
 * @Author S.huot s.huot@c2is.fr
 */
class Template
{

    public function create($pathBundle, $name, $type, $default = true)
    {
        $fs = new Filesystem();

        if (!$fs->exists($pathBundle.'/Resources/views/Content/'.$type.'/'.basename($name).'.html.twig')) {
            $fs->touch($pathBundle.'/Resources/views/Content/'.$type.'/'.basename($name).'.html.twig');
        }
        else {
            throw new Exception(sprintf("The file '%s' already exist", $name), 1);
        }
    }

    public function delete($pathBundle, $name, $type)
    {
        $fs = new Filesystem();

        if ($fs->exists($pathBundle.'/Resources/views/Content/'.$type.'/'.basename($name).'.html.twig')) {
            $fs->remove($pathBundle.'/Resources/views/Content/'.$type.'/'.basename($name).'.html.twig');
        }
    }

    public function listTemplate($pathBundle, $type, $default = true)
    {
        $finder = new Finder();
        $finder->files()->in($pathBundle.'/Resources/views/Content/'.$type.'/');

        $tabFinder = array();

        foreach ($finder as $file) {
            $tabFinder[$file->getFilename()] = $file->getFilename();
        }

        return $tabFinder;
    }

}
