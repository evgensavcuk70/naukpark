<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\NewsGallery;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['gallery_images'] = $this->record
            ->gallery
            ->pluck('image_path')
            ->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        $submitted = collect($this->data['gallery_images'] ?? [])
            ->map(fn ($path) => basename($path))
            ->toArray();

        $existing = $this->record->gallery()->pluck('image_path', 'id');

        foreach ($existing as $id => $imagePath) {
            if (!in_array($imagePath, $submitted, true)) {
                NewsGallery::where('id', $id)->delete();
            }
        }

        $alreadySaved = $existing->values()->toArray();

        foreach ($submitted as $imagePath) {
            if (!in_array($imagePath, $alreadySaved, true)) {
                NewsGallery::create([
                    'news_id' => $this->record->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
    }
}
