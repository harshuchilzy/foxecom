<?php

namespace App\Filament\Resources\ConfigurationResource\Pages;

use App\Filament\Resources\ConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfigurations extends ListRecords
{
    protected static string $resource = ConfigurationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('configure')
                ->label('Edit Configurations')
                ->url(static::$resource::getUrl('edit', ['record' => 1])), // Using a dummy ID
        ];
    }
}
