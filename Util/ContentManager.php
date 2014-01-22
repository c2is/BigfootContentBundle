<?php

namespace Bigfoot\Bundle\ContentBundle\Util;

class ContentManager
{

    /**
     * Sort a multi array by key
     *
     * @param $array
     * @param $key
     */
    public static function aasort (&$array, $key) {
        $sorter=array();
        $ret=array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va->{$key};
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        $array=$ret;
    }
}
