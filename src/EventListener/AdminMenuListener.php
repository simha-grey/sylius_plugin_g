<?php

namespace Roma\SyliusProductVariantPlugin\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu->addChild('roma_submenu')->setLabel('Roma Submenu');

        $newSubmenu->addChild('product_management_subitem',[
            'route' => 'roma_product_management_show'
            ])
            ->setLabel('Product Management');
    }
}
