<div x-data="menuBuilder()" x-init="init()" @open-modal.window="openModal()" @close-modal.window="closeModal()">
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $menu->name }}</h1>
                <p class="text-gray-500 mt-1">Location: <span class="font-medium capitalize">{{ $menu->location }}</span> | Slug: {{ $menu->slug }}</p>
            </div>
            <button wire:click="addItem" class="btn btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Menu Item
            </button>
        </div>

        @if(empty($items))
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <p class="text-gray-500 mb-4">No menu items yet</p>
                <button wire:click="addItem" class="btn btn-primary">
                    Add Your First Menu Item
                </button>
            </div>
        @else
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">Order</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu Item</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">URL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Target</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="menu-items-list">
                            @foreach($items as $item)
                                @include('livewire.partials.menu-item-row', ['item' => $item, 'depth' => 0])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal for Add/Edit Menu Item --}}
    <div x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-gray-900/50 z-40" @click.self="closeModal()"></div>
        <div class="flex min-h-full items-center justify-center p-4 relative z-50">
            <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="w-full max-w-md bg-white rounded-lg shadow-xl" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="editingItemId ? 'Edit Menu Item' : 'Add Menu Item'"></h3>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form @submit.prevent="submitForm()">
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                            <input type="text" x-model="formData.url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="/page or https://example.com">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                                <select x-model="formData.target" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="_self">Same Window (_self)</option>
                                    <option value="_blank">New Window (_blank)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Parent Item</label>
                                <select x-model="formData.parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    <option value="">-- Top Level --</option>
                                    <template x-for="item in flatItems" :key="item.id">
                                        <option :value="item.id" x-text="item.title"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CSS Classes</label>
                            <input type="text" x-model="formData.css_classes" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="custom-class">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icon (FontAwesome class)</label>
                            <input type="text" x-model="formData.icon" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="fas fa-home">
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
                        <button type="button" @click="closeModal()" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary" x-text="editingItemId ? 'Update' : 'Add'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SortableJS for drag and drop --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function menuBuilder() {
            return {
                showModal: false,
                editingItemId: null,
                formData: {
                    title: '',
                    url: '',
                    target: '_self',
                    css_classes: '',
                    icon: '',
                    parent_id: '',
                },
                flatItems: [],

                init() {
                    this.$watch('showModal', (value) => {
                        if (!value) this.resetForm();
                    });
                    this.loadFlatItems();
                    
                    // Close modal on Escape key
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && this.showModal) {
                            this.closeModal();
                        }
                    });
                },

                loadFlatItems() {
                    @this.loadFlatItems()
                        .then(response => {
                            this.flatItems = response;
                        });
                },

                openModal() {
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                },

                resetForm() {
                    this.editingItemId = null;
                    this.formData = {
                        title: '',
                        url: '',
                        target: '_self',
                        css_classes: '',
                        icon: '',
                        parent_id: '',
                    };
                },

                submitForm() {
                    const data = {
                        editingItemId: this.editingItemId,
                        editingItem: { ...this.formData },
                    };
                    
                    if (this.editingItemId) {
                        data.editingItem.parent_id = this.formData.parent_id || null;
                    } else {
                        data.editingItem.parent_id = this.formData.parent_id || null;
                    }
                    
                    @this.saveItem(data);
                    this.closeModal();
                },

                editItem(itemId) {
                    const item = this.flatItems.find(i => i.id === itemId);
                    if (item) {
                        this.editingItemId = itemId;
                        this.formData = {
                            title: item.title,
                            url: item.url || '',
                            target: item.target || '_self',
                            css_classes: item.css_classes || '',
                            icon: item.icon || '',
                            parent_id: item.parent_id || '',
                        };
                        this.showModal = true;
                    }
                },

                deleteItem(itemId) {
                    if (confirm('Are you sure you want to delete this menu item?')) {
                        @this.deleteItem(itemId);
                    }
                },

                toggleExpanded(itemId) {
                    @this.toggleExpanded(itemId);
                },

                isExpanded(itemId) {
                    return @this.isExpanded(itemId);
                },

                moveUp(itemId) {
                    @this.moveItemUp(itemId);
                },

                moveDown(itemId) {
                    @this.moveItemDown(itemId);
                },
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize SortableJS for drag and drop
            const list = document.getElementById('menu-items-list');
            if (list) {
                new Sortable(list, {
                    animation: 150,
                    handle: '.drag-handle',
                    delay: 100,
                    delayOnTouchOnly: true,
                    forceFallback: true,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        const rows = list.querySelectorAll('tr[data-item-id]');
                        const orderedIds = Array.from(rows).map(row => row.dataset.itemId);
                        @this.handleReorder(orderedIds);
                    },
                });
            }
        });
    </script>

    @push('scripts')
        <script>
            // Listen for Livewire events
            document.addEventListener('livewire:navigated', function() {
                // Reinitialize Sortable after Livewire navigation
                setTimeout(() => {
                    const list = document.getElementById('menu-items-list');
                    if (list && !list.sortable) {
                        new Sortable(list, {
                            animation: 150,
                            handle: '.drag-handle',
                            delay: 100,
                            delayOnTouchOnly: true,
                            forceFallback: true,
                            ghostClass: 'sortable-ghost',
                            chosenClass: 'sortable-chosen',
                            dragClass: 'sortable-drag',
                            onEnd: function(evt) {
                                const rows = list.querySelectorAll('tr[data-item-id]');
                                const orderedIds = Array.from(rows).map(row => row.dataset.itemId);
                                @this.handleReorder(orderedIds);
                            },
                        });
                    }
                }, 100);
            });
        </script>
    @endpush
</div>