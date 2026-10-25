<?php

namespace App\View\Components;

use App\Models\Menu;
use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuRenderer extends Component
{
    public string $location;
    public string $slug;
    public string $cssClass;
    public bool $showDropdown;
    public string $dropdownTrigger;
    public string $orientation;

    public function __construct(
        string $location = '',
        string $slug = '',
        string $cssClass = '',
        bool $showDropdown = true,
        string $dropdownTrigger = 'hover',
        string $orientation = 'horizontal'
    ) {
        $this->location = $location;
        $this->slug = $slug;
        $this->cssClass = $cssClass;
        $this->showDropdown = $showDropdown;
        $this->dropdownTrigger = $dropdownTrigger;
        $this->orientation = $orientation;
    }

    public function getMenu(): ?Menu
    {
        if ($this->slug) {
            return Menu::getBySlug($this->slug);
        }
        if ($this->location) {
            return Menu::getByLocation($this->location);
        }
        return null;
    }

    public function getMenuItems(): array
    {
        $menu = $this->getMenu();
        if (!$menu) {
            return [];
        }
        return $menu->getTree();
    }

    public function render(): View|Closure|string
    {
        return view('components.menu-renderer');
    }
}