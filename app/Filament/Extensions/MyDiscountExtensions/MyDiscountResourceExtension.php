<?php

namespace App\Filament\Extensions\MyDiscountExtensions;

use Closure;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TagsInput;
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
                    ->label('Spotlight Image')
                    ->image()
                    ->required(),
                FileUpload::make('data.mobile_banner_image')
                    ->label('Mobile Spotlight Image')
                    ->image()
                    ->required(),
                FileUpload::make('data.promo_image')
                    ->label('Offer Image')
                    ->image()
                    ->required(),
                FileUpload::make('data.mobile_promo_image')
                    ->label('Mobile Offer Image')
                    ->image()
                    ->required(),
                TextInput::make('data.marketing_header')
                    ->label('Marketing header')
                    ->columnSpanFull(),
                TagsInput::make('data.discount_features')
                    ->label('Discount Features')
                    ->placeholder('Add keywords (e.g., Bulk Buy, Mega Value)')
                    ->separator(',')
                    ->columnSpanFull(),
                Select::make('data.display_type')
                    ->multiple()
                    ->label('Active Positions')
                    ->options([
                        'spotlight' => 'Spotlight',
                        'latest-promotions' => 'Latest Promotions',
                        'banner' => 'Banner',
                    ])
                    ->required()
                    ->reactive()
                    ->columnSpanFull(),
                TextInput::make('data.video_url')
                    ->label('Video URL')
                    ->placeholder('https://example.com/video.mp4')
                    ->visible(fn ($get) => $get('data.banner_type') === 'video')
                    ->columnSpanFull(),
                Textarea::make('data.description')
                    ->label('Description')
                    ->autosize()
                    ->placeholder('Brief about the discount images')
                    ->columnSpanFull(),
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
