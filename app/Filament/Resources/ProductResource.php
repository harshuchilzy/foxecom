<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function getNavigationBadge(): ?string
    {
        return \App\Models\Product::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

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
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('slug')->unique(Product::class, 'slug', ignoreRecord: true),
                        TextInput::make('sku')->required()->unique(),
                        Select::make('status')
                            ->options([
                                'publish' => 'Published',
                                'draft' => 'Draft',
                            ])
                            ->default('draft'),
                    ])
                    ->columns(2),

                Section::make('Pricing & Inventory')
                    ->schema([
                        TextInput::make('price')->numeric()->required(),
                        TextInput::make('sale_price')->numeric()->nullable(),
                        TextInput::make('stock_quantity')->numeric(),
                    ])
                    ->columns(3),

                Section::make('Descriptions')
                    ->schema([
                        Textarea::make('short_description')->rows(2),
                        RichEditor::make('description')->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->maxFiles(5),
                    ]),

                Section::make('Shipping')
                    ->schema([
                        TextInput::make('weight')->numeric()->suffix('kg'),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('length')->numeric()->suffix('cm'),
                                TextInput::make('width')->numeric()->suffix('cm'),
                                TextInput::make('height')->numeric()->suffix('cm'),
                            ]),
                    ]),

                Section::make('Flags')
                    ->schema([
                        Toggle::make('virtual'),
                        Toggle::make('downloadable'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('name')->searchable()->sortable(),
                    TextColumn::make('sku'),
                    TextColumn::make('price')->money('USD'),
                    TextColumn::make('stock_quantity'),
                    BadgeColumn::make('status')
                        ->formatStateUsing(fn (string $state) => ucfirst($state))
                        ->colors([
                            'success' => 'publish',
                            'warning' => 'draft',
                        ]),
                ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
