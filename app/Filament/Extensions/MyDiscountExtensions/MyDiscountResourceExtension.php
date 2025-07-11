<?php

namespace App\Filament\Extensions\MyDiscountExtensions;

use Closure;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
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
                    ->required(),
                Select::make('data.banner_type')
                    ->label('Banner Type')
                    ->options([
                        'normal' => 'Normal',
                        'full_width' => 'Full Width',
                        'video' => 'Video',
                    ])
                    ->required()
                    ->reactive(),
                TextInput::make('data.video_url')
                    ->label('Video URL')
                    ->placeholder('https://example.com/video.mp4')
                    ->visible(fn ($get) => $get('data.banner_type') === 'video'),
                    
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
