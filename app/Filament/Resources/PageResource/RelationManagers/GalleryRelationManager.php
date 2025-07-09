<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryRelationManager extends RelationManager
{
    protected static string $relationship = 'gallery';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\FileUpload::make('value')
                    ->label('Image')
                    ->directory('page-meta-images'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                          
                Tables\Columns\TextColumn::make('value')
                    ->limit(50),

                Tables\Columns\ImageColumn::make('value')
                ->label('Image')
                ->visibility('private')
                ->defaultImageUrl(function ($record) {
                    return str_contains($record->type, 'image') ? null : url('placeholder-image.png');
                })
                ->height('50px')
                ->width('50px')
                ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}