<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 10;

    public static function getNavigationLabel(): string
    {
        return __('admin.navigation.payment_methods');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->alphaDash(),
                        Select::make('type')
                            ->required()
                            ->options([
                                'stripe' => 'Stripe (Credit/Debit Cards)',
                                'paypal' => 'PayPal',
                                'bank_transfer' => 'Bank Transfer',
                                'cash_on_delivery' => 'Cash on Delivery',
                            ])
                            ->native(false),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('icon')
                            ->label('Icon Class')
                            ->placeholder('fab fa-stripe, fas fa-university, etc.')
                            ->helperText('FontAwesome class or leave empty for auto'),
                    ])->columns(2),

                Section::make('Configuration')
                    ->schema([
                        KeyValue::make('config')
                            ->label('Gateway Configuration')
                            ->keyLabel('Key')
                            ->valueLabel('Value')
                            ->addActionLabel('Add Config')
                            ->columnSpanFull()
                            ->helperText('API keys, merchant IDs, webhook secrets, etc.'),
                    ]),

                Section::make('Availability')
                    ->schema([
                        Select::make('supported_currencies')
                            ->label('Supported Currencies')
                            ->multiple()
                            ->options([
                                'MKD' => 'MKD - Macedonian Denar',
                            ])
                            ->default(['MKD'])
                            ->native(false),
                        Select::make('supported_countries')
                            ->label('Supported Countries')
                            ->multiple()
                            ->options([
                                'MK' => 'Macedonia',
                            ])
                            ->default(['MK'])
                            ->native(false),
                        TextInput::make('min_amount')
                            ->label('Minimum Amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('MKD'),
                        TextInput::make('max_amount')
                            ->label('Maximum Amount')
                            ->numeric()
                            ->step(0.01)
                            ->prefix('MKD'),
                    ])->columns(2),

                Section::make('Fees')
                    ->schema([
                        TextInput::make('fee_percentage')
                            ->label('Fee Percentage (%)')
                            ->required()
                            ->numeric()
                            ->step(0.01)
                            ->default(0)
                            ->suffix('%'),
                        TextInput::make('fee_fixed')
                            ->label('Fixed Fee')
                            ->required()
                            ->numeric()
                            ->step(0.01)
                            ->default(0)
                            ->prefix('MKD'),
                    ])->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('is_sandbox')
                            ->label('Sandbox/Test Mode')
                            ->default(false)
                            ->helperText('Enable for testing with test credentials'),
                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'stripe' => 'purple',
                        'paypal' => 'blue',
                        'bank_transfer' => 'green',
                        'cash_on_delivery' => 'orange',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                TextColumn::make('supported_currencies')
                    ->label('Currencies')
                    ->badge()
                    ->separator(', ')
                    ->color('info'),
                TextColumn::make('fee_percentage')
                    ->label('Fee %')
                    ->suffix('%')
                    ->alignRight(),
                TextColumn::make('fee_fixed')
                    ->label('Fixed Fee')
                    ->money('MKD')
                    ->alignRight(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_sandbox')
                    ->label('Sandbox')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'stripe' => 'Stripe',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Bank Transfer',
                        'cash_on_delivery' => 'Cash on Delivery',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}