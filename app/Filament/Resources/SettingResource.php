<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('admin.navigation.settings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Setting Key')
                    ->placeholder('e.g., site_logo, site_name, contact_email'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'string' => 'Text',
                        'image' => 'Image',
                        'boolean' => 'True/False',
                        'json' => 'JSON',
                    ])
                    ->default('string')
                    ->reactive(),
                Forms\Components\TextInput::make('value')
                    ->label('Value')
                    ->maxLength(65535)
                    ->hidden(fn (Forms\Get $get) => in_array($get('type'), ['image', 'boolean', 'json'])),
                Forms\Components\FileUpload::make('value_image')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('settings')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'image')
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('value_boolean')
                    ->label('Enabled')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'boolean'),
                Forms\Components\Textarea::make('value_json')
                    ->label('JSON Value')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'json')
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('group')
                    ->required()
                    ->maxLength(255)
                    ->default('general'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'string' => 'gray',
                        'image' => 'amber',
                        'boolean' => 'green',
                        'json' => 'blue',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'appearance' => 'Appearance',
                        'contact' => 'Contact',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}