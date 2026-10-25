<tr data-item-id="{{ $item['id'] }}" class="@if($depth > 0) pl-@{($depth * 4)} @endif hover:bg-gray-50 transition-colors" style="@if($depth > 1) display: none; @endif">
    <td class="px-4 py-3">
        <button type="button" class="drag-handle text-gray-400 hover:text-gray-600 cursor-grab active:cursor-grabbing p-1" aria-label="Drag to reorder">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16M4 12h16"/>
            </svg>
        </button>
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center gap-3">
            @if($item['icon'])
                <i class="{{ $item['icon'] }} text-gray-400 text-lg"></i>
            @endif
            <div>
                <span class="font-medium text-gray-900">{{ $item['title'] }}</span>
                @if(!empty($item['children']))
                    <span class="ml-2 text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ count($item['children']) }} sub-items</span>
                @endif
                @if($depth > 0)
                    <span class="ml-2 text-xs text-gray-400">└─ Child</span>
                @endif
            </div>
        </div>
    </td>
    <td class="px-4 py-3">
        <span class="text-sm text-gray-500 truncate block max-w-xs" title="{{ $item['url'] }}">
            {{ $item['url'] ?: '—' }}
        </span>
    </td>
    <td class="px-4 py-3">
        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
            @if($item['target'] === '_blank')
                bg-blue-100 text-blue-800
            @else
                bg-gray-100 text-gray-800
            @endif">
            {{ $item['target'] === '_blank' ? 'New Tab' : 'Same Tab' }}
        </span>
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center gap-2">
            @if(!empty($item['children']))
                <button 
                    type="button" 
                    wire:click="toggleExpanded({{ $item['id'] }})" 
                    class="p-1 text-gray-400 hover:text-gray-600 rounded"
                    aria-label="@if($this->isExpanded($item['id'])) Collapse @else Expand @endif"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="@if($this->isExpanded($item['id'])) M5 15l7-7 7 7 @else M19 9l-7 7-7-7 @endif"/>
                    </svg>
                </button>
            @endif
            
            <button 
                type="button" 
                wire:click="moveItemUp({{ $item['id'] }})" 
                class="p-1 text-gray-400 hover:text-gray-600 rounded"
                aria-label="Move Up"
                title="Move Up"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                </svg>
            </button>
            
            <button 
                type="button" 
                wire:click="moveItemDown({{ $item['id'] }})" 
                class="p-1 text-gray-400 hover:text-gray-600 rounded"
                aria-label="Move Down"
                title="Move Down"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <button 
                type="button" 
                wire:click="editItem({{ $item['id'] }})" 
                class="p-1 text-gray-400 hover:text-amber-600 rounded"
                aria-label="Edit"
                title="Edit"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5M15 5v5M11 5l7 7M11 5l-5 5M11 5L5 11"/>
                </svg>
            </button>
            
            <button 
                type="button" 
                wire:click="deleteItem({{ $item['id'] }})" 
                class="p-1 text-gray-400 hover:text-red-600 rounded"
                aria-label="Delete"
                title="Delete"
                onclick="return confirm('Are you sure you want to delete this item?')"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            
            @if($depth === 0)
                <button 
                    type="button" 
                    wire:click="addItem({{ $item['id'] }})" 
                    class="p-1 text-gray-400 hover:text-green-600 rounded"
                    aria-label="Add Child"
                    title="Add Child Item"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            @endif
        </div>
    </td>
</tr>
@foreach($item['children'] as $child)
    @include('livewire.partials.menu-item-row', ['item' => $child, 'depth' => $depth + 1])
@endforeach