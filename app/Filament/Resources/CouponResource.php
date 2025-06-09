<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;


class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';

    public static function getNavigationGroup(): ?string
    {
        return 'Shop';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')->label('Coupon Code')->required()->unique(ignoreRecord: true),
                Select::make('discount_type')
                    ->options([
                        'percent' => 'Percentage',
                        'fixed_cart' => 'Fixed Cart Discount',
                        'fixed_product' => 'Fixed Product Discount',
                    ])
                    ->default('percent')
                    ->required(),
                TextInput::make('amount')->numeric()->required(),
                Textarea::make('description')->nullable(),

                Toggle::make('free_shipping'),
                DatePicker::make('expiry_date'),

                TextInput::make('minimum_amount')->numeric()->nullable(),
                TextInput::make('maximum_amount')->numeric()->nullable(),

                TextInput::make('usage_limit')->numeric()->nullable(),
                Toggle::make('individual_use'),
                Toggle::make('exclude_sale_items'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                BadgeColumn::make('discount_type'),
                TextColumn::make('amount')->label('Value'),
                TextColumn::make('usage_count')->label('Used'),
                TextColumn::make('usage_limit')->label('Limit'),
                TextColumn::make('expiry_date')->date(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
