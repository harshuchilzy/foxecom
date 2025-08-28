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

    protected static ?string $navigationLabel = 'Configuration';

    protected static ?string $navigationGroup = 'Settings';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->take(1);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Email Notifications')
                    ->schema([
                        Forms\Components\TextInput::make('admin_new_order_email')
                            ->label('Admin New Order Email')
                            ->email()
                            ->placeholder('admin@example.com'),
                            
                        Forms\Components\Toggle::make('admin_new_order_email_enabled')
                            ->label('Enable Admin New Order Email')
                            ->default(false),
                            
                        Forms\Components\TextInput::make('wholesale_new_customer_email')
                            ->label('Wholesale New Customer Notification Email')
                            ->email()
                            ->placeholder('wholesale@example.com'),
                            
                        Forms\Components\Toggle::make('wholesale_new_customer_email_enabled')
                            ->label('Enable Wholesale New Customer Notification')
                            ->default(false),
                    ])
                    ->columns(1),
                    
                Forms\Components\Section::make('Additional Settings')
                    ->schema([
                        Forms\Components\KeyValue::make('meta')
                            ->label('Meta Data')
                            ->keyLabel('Key')
                            ->valueLabel('Value')
                            ->reorderable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('admin_new_order_email')
                    ->label('Admin Email'),
                    
                Tables\Columns\IconColumn::make('admin_new_order_email_enabled')
                    ->label('Admin Enabled')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('wholesale_new_customer_email')
                    ->label('Wholesale Email'),
                    
                Tables\Columns\IconColumn::make('wholesale_new_customer_email_enabled')
                    ->label('Wholesale Enabled')
                    ->boolean(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListConfigurations::route('/'),
    //         'create' => Pages\CreateConfiguration::route('/create'),
    //         'edit' => Pages\EditConfiguration::route('/{record}/edit'),
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ConfigurationResource\Pages\ListConfigurations::route('/'),
            'edit' => \App\Filament\Resources\ConfigurationResource\Pages\EditConfiguration::route('/{record}/edit'),
        ];
    }
}
