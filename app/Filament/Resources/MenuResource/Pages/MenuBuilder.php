<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use App\Models\Menu;
use Filament\Resources\Pages\Page;

class MenuBuilder extends Page
{
    protected static string $resource = MenuResource::class;

    protected static string $view = 'filament.resources.menu-resource.pages.menu-builder';

    public Menu $record;

    public function mount(Menu $record): void
    {
        $this->record = $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('back')
                ->label('Back to Menus')
                ->url(static::getResource()::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
        ];
    }
}