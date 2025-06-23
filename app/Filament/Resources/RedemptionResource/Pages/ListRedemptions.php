<?php

namespace App\Filament\Resources\RedemptionResource\Pages;

use App\Filament\Resources\RedemptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRedemptions extends ListRecords
{
    protected static string $resource = RedemptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
