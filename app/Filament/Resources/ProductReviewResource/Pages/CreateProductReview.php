<?php

namespace App\Filament\Resources\ProductReviewResource\Pages;

use App\Filament\Resources\ProductReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductReview extends CreateRecord
{
    protected static string $resource = ProductReviewResource::class;

    protected array $imagesToSave = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->imagesToSave = $data['images'] ?? [];
        unset($data['images']);
        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->imagesToSave as $imagePath) {
            $this->record->images()->create(['path' => $imagePath]);
        }
    }
}
