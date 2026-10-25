<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Models\HomepageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Homepage';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('admin.navigation.homepage_sections');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Internal Name')
                    ->placeholder('e.g., hero, categories, featured_products, brands, arrivals, cta'),
                Forms\Components\TextInput::make('title')
                    ->maxLength(255)
                    ->label('Display Title'),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'hero' => 'Hero Slider',
                        'categories' => 'Featured Categories',
                        'products' => 'Featured Products',
                        'brands' => 'Top Brands',
                        'arrivals' => 'New Arrivals',
                        'cta' => 'Call to Action',
                        'custom' => 'Custom Content',
                    ])
                    ->default('custom'),
                Forms\Components\KeyValue::make('content')
                    ->label('Section Content (JSON)')
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                    ->addActionLabel('Add Field')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Visible on Homepage')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Display Order'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hero' => 'purple',
                        'categories' => 'blue',
                        'products' => 'green',
                        'brands' => 'amber',
                        'arrivals' => 'indigo',
                        'cta' => 'red',
                        'custom' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->label('Order'),
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
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'hero' => 'Hero Slider',
                        'categories' => 'Featured Categories',
                        'products' => 'Featured Products',
                        'brands' => 'Top Brands',
                        'arrivals' => 'New Arrivals',
                        'cta' => 'Call to Action',
                        'custom' => 'Custom Content',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Visibility')
                    ->placeholder('All')
                    ->trueLabel('Visible')
                    ->falseLabel('Hidden'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => Pages\ListHomepageSections::route('/'),
            'create' => Pages\CreateHomepageSection::route('/create'),
            'edit' => Pages\EditHomepageSection::route('/{record}/edit'),
        ];
    }
}