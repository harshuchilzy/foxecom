<?php

namespace App\Filament\Extensions\MyDiscountExtensions;

use Lunar\Admin\Filament\Widgets;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Lunar\Admin\Filament\Resources\DiscountResource;
use Lunar\Admin\Support\Extending\ListPageExtension;

class MyListDiscountPageExtension extends ListPageExtension
{
    public static function getImageFormComponents(): Component
    {
        return Group::make([
            FileUpload::make('data.banner_image')
                ->label('Banner Image')
                ->directory('discounts/banners')
                ->image()
                ->required(),
            FileUpload::make('data.promo_image')
                ->label('Promotional Image')
                ->directory('discounts/promos')
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

    public function headerActions(array $actions): array
    {
        $actions = [
            CreateAction::make()
                ->modalWidth('6xl')
                ->form([
                    Group::make([
                        DiscountResource::getNameFormComponent(),
                        DiscountResource::getHandleFormComponent(),
                        DiscountResource::getDiscountTypeFormComponent(),
                    ])->columns(3),
                    Group::make([
                        DiscountResource::getStartsAtFormComponent(),
                        DiscountResource::getEndsAtFormComponent(),
                    ])->columns(2),
                    static::getImageFormComponents(),
                ]),
        ];

        return $actions;
    }
}
