<?php

namespace LegoCMS\Services\View;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use LegoCMS\Services\View\Enums\Menu;
use LegoCMS\Support\NestedSet;

/**
 * Class MenuService
 *
 * @package LegoCMS\Services\View
 * @category Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/View/MenuService.php
 */
class MenuService
{
    /**
     * @var  \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * $request.
     *
     * @var Request
     */
    private $request;


    /**
     * $menuTree
     *
     * @var NestedSet
     */
    private $menuTree = null;

    /**
     * MenuService constructor.
     *
     * @param  \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->request = $app['request'];

        $this->buildMenuTree();
    }

    /**
     * Builds Menu Tree
     *
     * @return void
     */
    protected function buildMenuTree()
    {
        $menuConfig = \config('legocms.navigation');
        $modulesConfig = \config('legocms.modules');
        $modules = \collect($modulesConfig);

        $menu = new NestedSet();

        foreach ($menuConfig as $key => $menuItem) {
            $menu->add(
                [
                    'key' => $key,
                    'title' => $menuItem['title'],
                    'route' => $menuItem['route'],
                    'parent' => 'root',
                ]
            );

            if (\array_key_exists('children', $menuItem)) {
                foreach ($menuItem['children'] as $childKey => $childMenuItem) {
                    $menu->add(
                        [
                            'key' => $childKey,
                            'title' => $childMenuItem['title'],
                            'route' => $childMenuItem['route'],
                            'parent' => $key,
                        ]
                    );
                }
            }
        }

        foreach ($modulesConfig as $key => $item) {
            $menu->add([
                'key' => $key,
                'title' => $item['title'],
                'route' => $key . ".index",
                'parent' => $this->resolveParent($menu, $modules, $key),
            ]);
        }

        $this->menuTree  = $menu;
    }

    /**
     * Resolves parent key for the Item.
     *
     * @param  Illuminate\Support\Collection $menu
     * @param  Illuminate\Support\Collection $modules
     * @param  string  $itemKey
     *
     * @return void
     */
    private function resolveParent(&$menu, &$modules, $itemKey)
    {
        if ($item = $menu->firstWhere('key', $itemKey)) {
            return  $item['key'];
        }

        if ($item = $menu->firstWhere('route', $itemKey . ".index")) {
            return  $item['key'];
        }

        if ($item  = $modules->get($itemKey)) {
            return $item['parent'];
        }

        return 'root';
    }

    /**
     * Builds Global Menu.
     *
     * @return array
     */
    public function buildGlobalMenu()
    {

        $rootMenu = $this->menuTree->where('parent', 'root')->toArray();

        $globalmenu = [
            [
                'key' => 'dashboard',
                'title' => 'Dashboard',
                'route' => 'dashboard'
            ]
        ];

        if (!empty($rootMenu)) {
            $globalmenu = \array_merge(
                $globalmenu,
                Menu::SEPERATOR,
                $this->menuTree->where('parent', 'root')->toArray()
            );
        }


        return \array_merge(
            $globalmenu,
            Menu::SEPERATOR,
            [
                [
                    'key' => 'settings',
                    'title' => 'Settings',
                    'route' => 'settings.show'
                ],
                [
                    'key' => 'users',
                    'title' => 'Users',
                    'route' => 'users.index'
                ]
            ]
        );
    }

    /**
     * Builds Secondary Menu.
     *
     * @return array
     */
    public function buildSecondaryMenu()
    {
        $activeNavItem = $this->activeNavItem();

        $menuItemsWORootItems = $this->menuTree
            ->where('parent', '!=', 'root');

        $secondaryActiveMenuItem = $menuItemsWORootItems->firstWhere('key', $activeNavItem['secondary']);

        $section1 = $this->buildSection1($secondaryActiveMenuItem, $menuItemsWORootItems);

        $section2 = $this->buildSection2($secondaryActiveMenuItem, $menuItemsWORootItems);

        $section3 = $this->buildSection3($secondaryActiveMenuItem, $menuItemsWORootItems);

        $secondaryMenu = $section1->toArray();

        if ($section2->isNotEmpty()) {
            $secondaryMenu =  \array_merge(
                $secondaryMenu,
                Menu::SEPERATOR,
                $section2->toArray()
            );
        }

        if ($section3->isNotEmpty()) {
            $secondaryMenu =  \array_merge(
                $secondaryMenu,
                Menu::SEPERATOR,
                $section3->toArray()
            );
        }

        return $secondaryMenu;
    }

    /**
     * Builds Secondary Menu Section 1.
     *
     * @param  array  $activeNavItem
     * @param  NestedSet  $menuItems
     *
     * @return  Illuminate\Support\Collection
     */
    public function buildSection1($activeNavItem, $menuItems)
    {
        $items = $menuItems->ancestors($activeNavItem)->collect();

        if ($activeNavItem && \array_key_exists('parent', $activeNavItem) && $this->menuTree->parent($activeNavItem)['parent'] == 'root') {
            $siblings = $menuItems->siblings($activeNavItem, true)->collect();
            $items->push(...$siblings->toArray());
        }

        return $items;
    }

    /**
     * Builds Secondary Menu Section 2.
     *
     * @param  array  $activeNavItem
     * @param  NestedSet  $menuItems
     *
     * @return  Illuminate\Support\Collection
     */
    public function buildSection2($activeNavItem, $menuItems)
    {
        if ($activeNavItem && \array_key_exists('parent', $activeNavItem) && $this->menuTree->parent($activeNavItem)['parent'] == 'root') {
            $items = $menuItems->children($activeNavItem)->collect();
        } else {
            $items = $menuItems->siblings($activeNavItem, true)->collect();
        }

        return $items;
    }

    /**
     * Builds Secondary Menu Section 3.
     *
     * @param  array  $activeNavItem
     * @param  NestedSet  $menuItems
     *
     * @return  Illuminate\Support\Collection
     */
    public function buildSection3($activeNavItem, $menuItems)
    {
        if ($activeNavItem && \array_key_exists('parent', $activeNavItem) && $this->menuTree->parent($activeNavItem)['parent'] == 'root') {
            $children = $menuItems->children($activeNavItem);
            $items = \collect([]);

            if ($children->isNotEmpty()) {
                $children->each(function ($child) use ($items, $menuItems) {
                    $decendants = $menuItems->decendants($child);

                    if ($decendants->isNotEmpty()) {
                        $items->push(...$decendants->toArray());
                    }
                });
            }
        } else {
            $items = $menuItems->decendants($activeNavItem)->collect();
        }


        return $items;
    }

    /**
     * activeNavItem
     *
     * @return  array
     */
    public function activeNavItem()
    {
        if ($this->request->route()) {
            $routeName = $this->request->route()->getName();

            $activeMenus = \explode('.', $routeName);

            $currentActiveNav = \str_replace('-', '_', $activeMenus[1]);

            $globalActiveNavigation = $this->resolveGlobalActiveNavigation($currentActiveNav);
            $secondaryActiveNavigation = $currentActiveNav;

            return [
                'global' => $globalActiveNavigation,
                'secondary' => $secondaryActiveNavigation
            ];
        }
    }

    public function resolveGlobalActiveNavigation($activeModule)
    {
        if ($item = $this->menuTree->firstWhere('key', $activeModule)) {
            if ($item['parent'] == 'root') {
                return $item['key'];
            } else {
                return $this->resolveGlobalActiveNavigation($item['parent']);
            }
        };
    }

    /**
     * Is Active Menu.
     *
     * @param  string  $navCategory
     * @param  array  $navElement
     * @param  string  $navKey
     *
     * @return  boolean
     */
    public function isActiveMenu($navCategory, $navElement, $navKey)
    {
        $keysAreMatching = $this->activeNavItem()[$navCategory] === $navKey;

        if ($keysAreMatching) {
            return true;
        }

        $routeName = $this->request->route()->getName();
        $routeParts = \explode('.', $routeName);
        $currentActiveNav = \str_replace('-', '_', $routeParts[1]);

        $routePartsAreMatching = Str::startsWith($navElement['route'], $currentActiveNav);

        return $routePartsAreMatching;
    }
}
