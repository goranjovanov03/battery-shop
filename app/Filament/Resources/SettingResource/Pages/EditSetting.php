<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $type = $data['type'] ?? 'string';

        switch ($type) {
            case 'image':
                $data['value_image'] = $data['value'];
                break;
            case 'boolean':
                $data['value_boolean'] = $data['value'] === 'true';
                break;
            case 'json':
                $data['value_json'] = $data['value'];
                break;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->handleValueFields($data);
        return $data;
    }

    protected function handleValueFields(array $data): array
    {
        $type = $data['type'] ?? 'string';

        switch ($type) {
            case 'image':
                $data['value'] = $data['value_image'] ?? null;
                break;
            case 'boolean':
                $data['value'] = $data['value_boolean'] ? 'true' : 'false';
                break;
            case 'json':
                $data['value'] = $data['value_json'] ?? null;
                break;
            default:
                $data['value'] = $data['value'] ?? null;
        }

        unset($data['value_image'], $data['value_boolean'], $data['value_json']);

        return $data;
    }
}
