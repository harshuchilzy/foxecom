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

class RedemptionResource extends Resource
{
    protected static ?string $model = Redemption::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';
    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                RichEditor::make('content'),
                TextInput::make('discount')->numeric()->required(),

                FileUpload::make('offer_image')
                    ->image()->directory('offers'),

                FileUpload::make('product_image')
                    ->image()->directory('products'),

                Select::make('products')
                    ->label('Products')
                    // ->multiple()
                    ->searchable()
                    ->relationship('products', 'id')
                    ->getSearchResultsUsing(function (string $search) {
                        return Product::all()
                            ->filter(function ($product) use ($search) {
                                $name = data_get($product->attribute_data['name']->getValue(), 'en');
                                return str_contains(strtolower($name), strtolower($search));
                            })
                            ->mapWithKeys(function ($product) {
                                $name = data_get($product->attribute_data['name']->getValue(), 'en', 'Unnamed Product');
                                return [$product->id => $name];
                            });
                    })
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return data_get($record->attribute_data['name']->getValue(), 'en', 'Unnamed Product');
                    })
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
