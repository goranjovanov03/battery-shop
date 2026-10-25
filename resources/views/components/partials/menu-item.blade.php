@php
    $hasChildren = !empty($item['children']);
    $isDropdown = $hasChildren && $showDropdown && $depth === 0;
    $dropdownId = 'dropdown-' . $item['id'] . '-' . $depth;
@endphp

<li class="relative group" role="none" x-data="{ 
    dropdownId: '{{ $dropdownId }}',
    closeTimeout: null,
    get open() {
        return $store.menu.openDropdowns.includes(this.dropdownId);
    },
    set open(val) {
        if (val) {
            $store.menu.openDropdowns = [this.dropdownId];
        } else {
            $store.menu.openDropdowns = $store.menu.openDropdowns.filter(i => i !== this.dropdownId);
        }
    },
    scheduleClose() {
        this.closeTimeout = setTimeout(() => { this.open = false; }, 150);
    },
    cancelClose() {
        if (this.closeTimeout) clearTimeout(this.closeTimeout);
    },
    init() {
        this.open = false;
    }
}">
    @if($isDropdown)
        {{-- Top-level dropdown item --}}
        <div class="relative" @mouseleave="scheduleClose()" @mouseenter="cancelClose()">
            <button 
                type="button"
                role="menuitem"
                aria-haspopup="true"
                :aria-expanded="open"
                aria-controls="{{ $dropdownId }}"
                class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 hover:bg-gray-100 rounded-lg transition-colors"
                @click="open = !open"
                @keydown="if(['Escape','Enter',' '].includes($event.key)) { $event.preventDefault(); if($event.key==='Escape') open=false; else open=!open; }"
                @mouseenter="cancelClose(); open = true"
            >
                @if($item['icon'])
                    <i class="{{ $item['icon'] }} text-lg"></i>
                @endif
                <span>{{ $item['title'] }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown menu --}}
            <div 
                id="{{ $dropdownId }}"
                role="menu"
                class="absolute left-0 top-full mt-0.5 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 invisible transform translate-y-1"
                x-transition:enter-end="opacity-100 visible transform translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 visible transform translate-y-0"
                x-transition:leave-end="opacity-0 invisible transform translate-y-1"
                @click.outside="open = false"
                @mouseenter="cancelClose()"
                @mouseleave="scheduleClose()"
            >
                <ul class="space-y-1" role="none">
                    @foreach($item['children'] as $child)
                        @include('components.partials.menu-item', ['item' => $child, 'depth' => $depth + 1, 'showDropdown' => false])
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        {{-- Regular menu item --}}
        <a 
            href="{{ $item['url'] ?: '#' }}"
            target="{{ $item['target'] }}"
            role="menuitem"
            class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 hover:bg-gray-100 rounded-lg transition-colors {{ $item['css_classes'] }}"
            @if($item['target'] === '_blank') rel="noopener noreferrer" @endif
        >
            @if($item['icon'])
                <i class="{{ $item['icon'] }} text-lg"></i>
            @endif
            <span>{{ $item['title'] }}</span>
        </a>
    @endif
</li>