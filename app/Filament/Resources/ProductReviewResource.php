<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewResource\Pages;
use App\Filament\Resources\ProductReviewResource\RelationManagers;
use App\Models\ProductReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('customer_id')->default(auth()->user()?->customer?->id),

                Select::make('product_id')
                    ->label('Product')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return \Lunar\Models\Product::all()
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
                    ->required(),

                Textarea::make('content')->required()->rows(4),

                TextInput::make('rating')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->required(),

                Select::make('approved')
                    ->label('Approval Status')
                    ->options([
                        1 => 'Approved',
                        0 => 'Disapproved',
                        // '' => 'Pending',
                        null => 'Pending',
                    ])
                    ->nullable()
                    ->default(null),

                FileUpload::make('images_data')
                    ->label('Review Images')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->directory('review-images')
                    ->preserveFilenames()
                    ->maxSize(2048)
                    ->default(fn ($record) => $record?->images->pluck('path')->all() ?? []),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->label('Product'),
                TextColumn::make('customer.full_name')->label('Customer'),
                TextColumn::make('rating'),
                TextColumn::make('approved')->formatStateUsing(fn ($state) => match ($state) {
                    1, true => 'Approved',
                    0, false => 'Disapproved',
                    null, '' => 'Pending',
                    default => 'Unknown',
                }),
                ImageColumn::make('images.path')->limit(2)->label('Images'),
                TextColumn::make('created_at')->dateTime(),
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
            'index' => Pages\ListProductReviews::route('/'),
            'create' => Pages\CreateProductReview::route('/create'),
            'edit' => Pages\EditProductReview::route('/{record}/edit'),
        ];
    }
}
