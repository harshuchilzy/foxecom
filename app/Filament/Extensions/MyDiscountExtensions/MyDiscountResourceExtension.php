<?php

namespace App\Filament\Extensions\MyDiscountExtensions;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Lunar\Admin\Support\Extending\ResourceExtension;

class MyDiscountResourceExtension extends ResourceExtension
{
    public static function getImageFormComponents(): Component
    {
        return Section::make('Images')
            ->schema([
                FileUpload::make('data.banner_image')
                    ->label('Banner Image')
                    ->image()
                    ->required(),
                FileUpload::make('data.promo_image')
                    ->label('Promotional Image')
                    ->image()
                    ->required()
            ])->columns(2);
    }

    public function extendForm(Form $form): Form
    {
        return $form->schema([
            static::getImageFormComponents(),
            ...$form->getComponents(withHidden: true),
        ]);

    }

    public function extendTable(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('data.banner_image')
                ->label('Banner')
                ->disk('public')
                ->size(50)
                ->alignCenter(),
            ImageColumn::make('data.promo_image')
                ->alignCenter()
                ->label('Promotion')
                ->disk('public')
                ->size(50),
            ...$table->getColumns(),
        ])
            ->actions([
                ...$table->getActions(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->delete();
                    }),
            ]);
    }
}
