<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make('Активні')
                ->icon('heroicon-o-newspaper')
                ->badge(News::query()->where('is_archived', false)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_archived', false)),

            'archive' => Tab::make('Архів')
                ->icon('heroicon-o-archive-box')
                ->badge(News::query()->where('is_archived', true)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_archived', true)),

            'all' => Tab::make('Усі')
                ->icon('heroicon-o-rectangle-stack')
                ->badge(News::query()->count()),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'active';
    }
}
