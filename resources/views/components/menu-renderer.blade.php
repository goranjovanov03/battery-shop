@php
    $menuItems = $getMenuItems();
    $isVertical = $orientation === 'vertical';
@endphp

@if(!empty($menuItems))
    <nav class="{{ $cssClass }}" x-data="menuNavigation">
        <ul class="{{ $isVertical ? 'flex flex-col gap-2' : 'flex flex-col sm:flex-row items-center gap-1 sm:gap-4' }}" role="{{ $isVertical ? 'list' : 'menubar' }}">
            @foreach($menuItems as $item)
                @include('components.partials.menu-item', ['item' => $item, 'depth' => 0, 'showDropdown' => $showDropdown && !$isVertical])
            @endforeach
        </ul>
    </nav>
@endif