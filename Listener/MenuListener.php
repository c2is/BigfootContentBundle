<?php

namespace Bigfoot\Bundle\ContentBundle\Listener;

use Bigfoot\Bundle\CoreBundle\Event\MenuEvent;
use Bigfoot\Bundle\CoreBundle\Theme\Menu\Item;

class MenuListener
{
    /**
     * Add entry to the sidebar menu
     *
     * @param MenuEvent $event
     */
    function onMenuGenerate(MenuEvent $event)
    {
        $menu = $event->getMenu();

        if ($menu->getName() == 'sidebar_menu') {
            $menu->addItem(new Item('content_settings', 'Content','admin_content_widget'));
            $menu->addOnItem('content_settings',new Item('content_sidebar_settings', 'Dashboard','admin_dashboard'));
            $menu->addOnItem('content_settings',new Item('content_sidebar_settings', 'Static Content','admin_staticcontent'));
            $menu->addOnItem('content_settings',new Item('content_sidebar_settings', 'Page','admin_page'));
        }
    }
}
