<?php

namespace App\Livewire;

use App\Models\Menu;
use App\Models\MenuItem;
use Livewire\Component;
use Livewire\Attributes\On;

class MenuBuilder extends Component
{
    public Menu $menu;
    public $items = [];
    public $expandedItems = [];
    public $editingItemId = null;
    public $editingItem = [
        'title' => '',
        'url' => '',
        'target' => '_self',
        'css_classes' => '',
        'icon' => '',
        'parent_id' => null,
    ];

    public function mount(Menu $menu)
    {
        $this->menu = $menu;
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = $this->menu->allItems()
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'url' => $item->url,
                    'target' => $item->target,
                    'css_classes' => $item->css_classes,
                    'icon' => $item->icon,
                    'order' => $item->order,
                    'parent_id' => $item->parent_id,
                    'depth' => $item->parent_id ? 1 : 0,
                    'children' => [],
                ];
            })
            ->toArray();

        $this->buildTree();
    }

    public function buildTree()
    {
        $itemMap = [];
        $roots = [];

        foreach ($this->items as &$item) {
            $item['children'] = [];
            $itemMap[$item['id']] = &$item;
        }

        foreach ($this->items as &$item) {
            if ($item['parent_id'] && isset($itemMap[$item['parent_id']])) {
                $itemMap[$item['parent_id']]['children'][] = &$item;
            } else {
                $roots[] = &$item;
            }
        }

        $this->items = $roots;
    }

    public function addItem($parentId = null)
    {
        $this->resetEditingItem();
        $this->editingItem['parent_id'] = $parentId;
        $this->dispatch('open-modal', 'menu-item-modal');
    }

    public function editItem($itemId)
    {
        $item = MenuItem::find($itemId);
        if ($item) {
            $this->editingItemId = $item->id;
            $this->editingItem = [
                'title' => $item->title,
                'url' => $item->url,
                'target' => $item->target,
                'css_classes' => $item->css_classes,
                'icon' => $item->icon,
                'parent_id' => $item->parent_id,
            ];
            $this->dispatch('open-modal', 'menu-item-modal');
        }
    }

    public function saveItem()
    {
        $this->validate([
            'editingItem.title' => 'required|string|max:255',
            'editingItem.url' => 'nullable|string|max:500',
            'editingItem.target' => 'required|in:_self,_blank',
        ]);

        if ($this->editingItemId) {
            $item = MenuItem::find($this->editingItemId);
            $item->update($this->editingItem);
        } else {
            $maxOrder = MenuItem::where('menu_id', $this->menu->id)
                ->where('parent_id', $this->editingItem['parent_id'])
                ->max('order') ?? 0;
            
            MenuItem::create([
                'menu_id' => $this->menu->id,
                'parent_id' => $this->editingItem['parent_id'],
                'title' => $this->editingItem['title'],
                'url' => $this->editingItem['url'],
                'target' => $this->editingItem['target'],
                'css_classes' => $this->editingItem['css_classes'],
                'icon' => $this->editingItem['icon'],
                'order' => $maxOrder + 1,
                'is_active' => true,
            ]);
        }

        $this->resetEditingItem();
        $this->dispatch('close-modal', 'menu-item-modal');
        $this->loadItems();
    }

    public function deleteItem($itemId)
    {
        MenuItem::find($itemId)?->delete();
        $this->loadItems();
    }

    public function toggleExpanded($itemId)
    {
        if (in_array($itemId, $this->expandedItems)) {
            $this->expandedItems = array_diff($this->expandedItems, [$itemId]);
        } else {
            $this->expandedItems[] = $itemId;
        }
    }

    public function isExpanded($itemId)
    {
        return in_array($itemId, $this->expandedItems);
    }

    #[On('menu-items-reordered')]
    public function handleReorder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            MenuItem::where('id', $id)->update(['order' => $index + 1]);
        }
        $this->loadItems();
    }

    public function moveItemUp($itemId)
    {
        $item = MenuItem::find($itemId);
        if ($item) {
            $sibling = MenuItem::where('menu_id', $this->menu->id)
                ->where('parent_id', $item->parent_id)
                ->where('order', '<', $item->order)
                ->orderBy('order', 'desc')
                ->first();
            
            if ($sibling) {
                $itemOrder = $item->order;
                $item->update(['order' => $sibling->order]);
                $sibling->update(['order' => $itemOrder]);
                $this->loadItems();
            }
        }
    }

    public function moveItemDown($itemId)
    {
        $item = MenuItem::find($itemId);
        if ($item) {
            $sibling = MenuItem::where('menu_id', $this->menu->id)
                ->where('parent_id', $item->parent_id)
                ->where('order', '>', $item->order)
                ->orderBy('order', 'asc')
                ->first();
            
            if ($sibling) {
                $itemOrder = $item->order;
                $item->update(['order' => $sibling->order]);
                $sibling->update(['order' => $itemOrder]);
                $this->loadItems();
            }
        }
    }

    public function resetEditingItem()
    {
        $this->editingItemId = null;
        $this->editingItem = [
            'title' => '',
            'url' => '',
            'target' => '_self',
            'css_classes' => '',
            'icon' => '',
            'parent_id' => null,
        ];
    }

    public function loadFlatItems()
    {
        return $this->menu->allItems()
            ->where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'title', 'parent_id'])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.menu-builder');
    }
}