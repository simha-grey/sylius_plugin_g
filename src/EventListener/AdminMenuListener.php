<?php

namespace Roma\SyliusProductVariantPlugin\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu->addChild('new')->setLabel('Roman Submenu');

        $newSubmenu->addChild('new-subitem')->setLabel('Product Managment');
    }
}
