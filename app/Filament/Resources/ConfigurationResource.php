<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfigurationResource\Pages;
use App\Filament\Resources\ConfigurationResource\RelationManagers;
use App\Models\Configuration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConfigurationResource extends Resource
{
    protected static ?string $model = Configuration::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Configurations';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Admin Order Email')
                    ->schema([
                        Forms\Components\TextInput::make('admin_new_order_email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->default(fn() => Configuration::getValue('admin_new_order_email', '')),
                        Forms\Components\Toggle::make('admin_new_order_email_enabled')
                            ->label('Enable Notification')
                            ->default(fn() => Configuration::getValue('admin_new_order_email_enabled', false))
                    ]),
                    
                Forms\Components\Section::make('Wholesale Customer Notification')
                    ->schema([
                        Forms\Components\TextInput::make('wholesale_new_customer_email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->default(fn() => Configuration::getValue('wholesale_new_customer_email', '')),
                        Forms\Components\Toggle::make('wholesale_new_customer_email_enabled')
                            ->label('Enable Notification')
                            ->default(fn() => Configuration::getValue('wholesale_new_customer_email_enabled', false))
                    ]),
                    
                Forms\Components\Section::make('Store Notice')
                    ->schema([
                        Forms\Components\Textarea::make('store_notice')
                            ->label('Notice Text')
                            ->rows(3)
                            ->default(fn() => Configuration::getValue('store_notice', '')),
                        Forms\Components\Toggle::make('store_notice_enabled')
                            ->label('Enable Store Notice')
                            ->default(fn() => Configuration::getValue('store_notice_enabled', false))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key'),
                Tables\Columns\TextColumn::make('value')->limit(50),
                Tables\Columns\BooleanColumn::make('enabled')->label('Enabled'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ConfigurationResource\Pages\ListConfigurations::route('/'),
            'create' => \App\Filament\Resources\ConfigurationResource\Pages\CreateConfiguration::route('/create'),
            'edit' => \App\Filament\Resources\ConfigurationResource\Pages\EditConfiguration::route('/{record}/edit'),
        ];
    }
}
