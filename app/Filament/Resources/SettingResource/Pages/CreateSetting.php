<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
