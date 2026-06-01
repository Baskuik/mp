<?php

namespace App\Filament\Resources\Listings\Pages;

use App\Filament\Resources\Listings\ListingResource;
use App\Models\ListingImage;
use Filament\Resources\Pages\CreateRecord;

class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Store images temporarily before they're removed
        $this->images = $data['images'] ?? [];

        // Remove images from data so they don't try to save to the model
        unset($data['images']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Save the images after the record is created
        if (!empty($this->images)) {
            foreach ($this->images as $index => $imagePath) {
                ListingImage::create([
                    'listing_id' => $this->record->listing_id,
                    'path' => $imagePath,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
