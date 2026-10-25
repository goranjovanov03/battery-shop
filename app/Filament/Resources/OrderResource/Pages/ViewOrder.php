<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('mark_processing')
                ->label('Mark Processing')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status === 'pending')
                ->action(fn ($record) => $record->update(['status' => 'processing'])),
            Actions\Action::make('mark_shipped')
                ->label('Mark Shipped')
                ->icon('heroicon-o-truck')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn ($record) => in_array($record->status, ['pending', 'processing']))
                ->action(fn ($record) => $record->update(['status' => 'shipped'])),
            Actions\Action::make('mark_delivered')
                ->label('Mark Delivered')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->status === 'shipped')
                ->action(fn ($record) => $record->update(['status' => 'delivered'])),
            Actions\Action::make('mark_cancelled')
                ->label('Cancel Order')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn ($record) => ! in_array($record->status, ['delivered', 'cancelled', 'refunded']))
                ->action(fn ($record) => $record->update(['status' => 'cancelled'])),
        ];
    }
}
