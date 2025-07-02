<?php

namespace App\Filament\Resources\RedemptionResource\Pages;

use App\Filament\Resources\RedemptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRedemption extends CreateRecord
{
    protected static string $resource = RedemptionResource::class;
    protected array $collectionIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $collectionIds = $data['rules']['collection_ids'] ?? [];
        $data['rules']['collection_ids'] = $collectionIds;

        $this->collectionIds = $collectionIds;

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->collections()->sync($this->collectionIds ?? []);
    }
}
