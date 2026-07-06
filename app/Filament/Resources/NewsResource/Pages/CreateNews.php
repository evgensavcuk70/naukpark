<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\NewsGallery;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function afterCreate(): void
    {
        $files = $this->data['gallery_images'] ?? [];

        foreach ($files as $path) {

            NewsGallery::create([
                'news_id' => $this->record->id,
                'image_path' => basename($path),
            ]);
        }
    }
}
