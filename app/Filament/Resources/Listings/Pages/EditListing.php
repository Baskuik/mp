<?php

namespace App\Filament\Resources\Listings\Pages;

use App\Filament\Resources\Listings\ListingResource;
use App\Models\ListingImage;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing images for the edit form
        $data['images'] = $this->record->images()->pluck('path')->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store images temporarily before they're removed
        $this->images = $data['images'] ?? [];

        // Remove images from data so they don't try to save to the model
        unset($data['images']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Delete old images and save new ones if images were updated
        if (!empty($this->images)) {
            // Delete all old images
            ListingImage::where('listing_id', $this->record->listing_id)->delete();

            // Save the new images
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

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
