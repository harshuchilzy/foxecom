<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedemptionResource\Pages;
use App\Filament\Resources\RedemptionResource\RelationManagers;
use App\Models\Redemption;
use Lunar\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Lunar\Models\Collection;

class RedemptionResource extends Resource
{
    protected static ?string $model = Redemption::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('title')->required(),
                // RichEditor::make('content'),
                // TextInput::make('discount')->numeric()->required(),

                // FileUpload::make('offer_image')
                //     ->image()->directory('offers'),

                // FileUpload::make('product_image')
                //     ->image()->directory('products'),

                // Select::make('products')
                //     ->label('Products')
                //     ->multiple()
                //     ->searchable()
                //     ->relationship('products', 'id')
                //     ->getSearchResultsUsing(function (string $search) {
                //         return Product::all()
                //             ->filter(function ($product) use ($search) {
                //                 $name = data_get($product->attribute_data['name']->getValue(), 'en');
                //                 return str_contains(strtolower($name), strtolower($search));
                //             })
                //             ->mapWithKeys(function ($product) {
                //                 $name = data_get($product->attribute_data['name']->getValue(), 'en', 'Unnamed Product');
                //                 return [$product->id => $name];
                //             });
                //     })
                //     ->getOptionLabelFromRecordUsing(function ($record) {
                //         return data_get($record->attribute_data['name']->getValue(), 'en', 'Unnamed Product');
                //     })

                Grid::make(1)->schema([
                    TextInput::make('title')->required(),
                    RichEditor::make('content'),
                    // TextInput::make('discount')->numeric()->required(),
                ]),

                Grid::make(2)->schema([
                    FileUpload::make('offer_image')
                        ->image()->directory('offers'),
                    FileUpload::make('product_image')
                        ->image()->directory('products'),
                ]),

                Section::make('Coupon Rules')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('rules.discount_type')
                                ->label('Discount Type')
                                ->options([
                                    'fixed_cart' => 'Fixed Cart Discount',
                                    'percentage' => 'Percentage Discount',
                                    'fixed_product' => 'Fixed Product Discount',
                                ])
                                ->required(),

                            TextInput::make('rules.coupon_amount')
                                ->label('Coupon Amount')
                                ->numeric()
                                ->required(),

                            Toggle::make('rules.allow_free_shipping')->label('Allow Free Shipping'),
                            DateTimePicker::make('rules.expires_at')->label('Coupon Expiry Date'),

                            TextInput::make('rules.min_spend')->label('Minimum Spend')->numeric(),
                            TextInput::make('rules.max_spend')->label('Maximum Spend')->numeric(),

                            Toggle::make('rules.individual_use')->label('Individual Use Only'),
                            Toggle::make('rules.exclude_sale_items')->label('Exclude Sale Items'),

                            TextInput::make('rules.usage_limit_total')
                                ->label('Total Usage Limit')
                                ->numeric()
                                ->minValue(1),

                            TextInput::make('rules.usage_limit_per_user')
                                ->label('Usage Limit per User')
                                ->numeric()
                                ->minValue(1),

                            Select::make('rules.collection_ids')
                                ->label('Applicable Collections')
                                ->multiple()
                                ->options(
                                    \Lunar\Models\Collection::all()->mapWithKeys(function ($collection) {
                                        $name = data_get($collection->attribute_data['name']->getValue(), 'en', 'Unnamed Collection');
                                        return [$collection->id => $name];
                                    })
                                )
                        ])
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->icon('heroicon-o-receipt-percent')
                    ->compact()
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('discount')->sortable(),
                Tables\Columns\ImageColumn::make('offer_image'),
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
            'index' => Pages\ListRedemptions::route('/'),
            'create' => Pages\CreateRedemption::route('/create'),
            'edit' => Pages\EditRedemption::route('/{record}/edit'),
        ];
    }
}
