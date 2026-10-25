<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Main Header Menu
        $headerMenu = Menu::updateOrCreate(
            ['slug' => 'main-nav'],
            [
                'name' => 'Main Navigation',
                'location' => 'header',
                'description' => 'Primary header navigation menu',
                'is_active' => true,
            ]
        );

        $headerItems = [
            [
                'title' => 'Home',
                'url' => '/',
                'order' => 1,
                'icon' => 'fas fa-home',
            ],
            [
                'title' => 'Shop',
                'url' => '/products',
                'order' => 2,
                'icon' => 'fas fa-store',
                'children' => [
                    ['title' => 'All Batteries', 'url' => '/products', 'order' => 1],
                    ['title' => 'Categories', 'url' => '/categories', 'order' => 2, 'icon' => 'fas fa-list'],
                    ['title' => 'Brands', 'url' => '/brands', 'order' => 3, 'icon' => 'fas fa-tags'],
                    [
                        'title' => 'By Vehicle',
                        'url' => '/battery-finder',
                        'order' => 4,
                        'icon' => 'fas fa-car',
                        'children' => [
                            ['title' => 'Car Batteries', 'url' => '/products?vehicle=car', 'order' => 1],
                            ['title' => 'Truck Batteries', 'url' => '/products?vehicle=truck', 'order' => 2],
                            ['title' => 'Motorcycle Batteries', 'url' => '/products?vehicle=motorcycle', 'order' => 3],
                            ['title' => 'Marine Batteries', 'url' => '/products?vehicle=marine', 'order' => 4],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Battery Finder',
                'url' => '/battery-finder',
                'order' => 3,
                'icon' => 'fas fa-search',
            ],
            [
                'title' => 'Deals',
                'url' => '/deals',
                'order' => 4,
                'icon' => 'fas fa-percent',
                'children' => [
                    ['title' => 'Special Offers', 'url' => '/deals', 'order' => 1],
                    ['title' => 'Clearance', 'url' => '/clearance', 'order' => 2],
                    ['title' => 'Bulk Discounts', 'url' => '/bulk-discounts', 'order' => 3],
                ],
            ],
            [
                'title' => 'Support',
                'url' => '/support',
                'order' => 5,
                'icon' => 'fas fa-headset',
                'children' => [
                    ['title' => 'Contact Us', 'url' => '/contact', 'order' => 1, 'icon' => 'fas fa-envelope'],
                    ['title' => 'Shipping Info', 'url' => '/shipping', 'order' => 2, 'icon' => 'fas fa-truck'],
                    ['title' => 'Returns', 'url' => '/returns', 'order' => 3, 'icon' => 'fas fa-undo'],
                    ['title' => 'Warranty', 'url' => '/warranty', 'order' => 4, 'icon' => 'fas fa-shield-alt'],
                    ['title' => 'Installation Guide', 'url' => '/installation-guide', 'order' => 5, 'icon' => 'fas fa-tools'],
                    ['title' => 'FAQ', 'url' => '/faq', 'order' => 6, 'icon' => 'fas fa-question-circle'],
                ],
            ],
            [
                'title' => 'About Us',
                'url' => '/about',
                'order' => 6,
                'children' => [
                    ['title' => 'Our Story', 'url' => '/about', 'order' => 1],
                    ['title' => 'Careers', 'url' => '/careers', 'order' => 2],
                    ['title' => 'Blog', 'url' => '/blog', 'order' => 3],
                    ['title' => 'Press', 'url' => '/press', 'order' => 4],
                ],
            ],
        ];

        $this->createMenuItems($headerMenu, $headerItems);

        // Footer Shop Menu
        $footerShopMenu = Menu::updateOrCreate(
            ['slug' => 'footer-shop'],
            [
                'name' => 'Footer Shop Links',
                'location' => 'footer-shop',
                'description' => 'Shop links in footer',
                'is_active' => true,
            ]
        );

        $footerShopItems = [
            ['title' => 'All Batteries', 'url' => '/products', 'order' => 1],
            ['title' => 'Categories', 'url' => '/categories', 'order' => 2],
            ['title' => 'Brands', 'url' => '/brands', 'order' => 3],
            ['title' => 'Battery Finder', 'url' => '/battery-finder', 'order' => 4],
            ['title' => 'New Arrivals', 'url' => '/products?sort=newest', 'order' => 5],
            ['title' => 'Best Sellers', 'url' => '/products?sort=best-sellers', 'order' => 6],
        ];

        $this->createMenuItems($footerShopMenu, $footerShopItems);

        // Footer Help Menu
        $footerHelpMenu = Menu::updateOrCreate(
            ['slug' => 'footer-help'],
            [
                'name' => 'Footer Help Links',
                'location' => 'footer-help',
                'description' => 'Help/Support links in footer',
                'is_active' => true,
            ]
        );

        $footerHelpItems = [
            ['title' => 'Contact Us', 'url' => '/contact', 'order' => 1],
            ['title' => 'Shipping Info', 'url' => '/shipping', 'order' => 2],
            ['title' => 'Returns & Exchanges', 'url' => '/returns', 'order' => 3],
            ['title' => 'Warranty Info', 'url' => '/warranty', 'order' => 4],
            ['title' => 'FAQ', 'url' => '/faq', 'order' => 5],
            ['title' => 'Installation Guide', 'url' => '/installation-guide', 'order' => 6],
        ];

        $this->createMenuItems($footerHelpMenu, $footerHelpItems);

        // Footer Legal Menu
        $footerLegalMenu = Menu::updateOrCreate(
            ['slug' => 'footer-legal'],
            [
                'name' => 'Footer Legal Links',
                'location' => 'footer-legal',
                'description' => 'Legal links in footer',
                'is_active' => true,
            ]
        );

        $footerLegalItems = [
            ['title' => 'Privacy Policy', 'url' => '/privacy', 'order' => 1],
            ['title' => 'Terms of Service', 'url' => '/terms', 'order' => 2],
            ['title' => 'Cookie Policy', 'url' => '/cookies', 'order' => 3],
            ['title' => 'Accessibility', 'url' => '/accessibility', 'order' => 4],
        ];

        $this->createMenuItems($footerLegalMenu, $footerLegalItems);

        $this->command->info('Menus seeded successfully!');
    }

    private function createMenuItems(Menu $menu, array $items, $parentId = null): void
    {
        foreach ($items as $itemData) {
            $children = $itemData['children'] ?? [];
            unset($itemData['children']);

            $menuItem = MenuItem::updateOrCreate(
                [
                    'menu_id' => $menu->id,
                    'title' => $itemData['title'],
                    'parent_id' => $parentId,
                ],
                array_merge($itemData, [
                    'menu_id' => $menu->id,
                    'parent_id' => $parentId,
                    'target' => $itemData['target'] ?? '_self',
                    'icon' => $itemData['icon'] ?? null,
                    'css_classes' => $itemData['css_classes'] ?? null,
                    'is_active' => true,
                ])
            );

            if (!empty($children)) {
                $this->createMenuItems($menu, $children, $menuItem->id);
            }
        }
    }
}