<?php

// Filament-ресурс для управління категоріями новин.
namespace App\Filament\Resources;

use App\Filament\Resources\NewsCategoryResource\Pages;
use App\Models\NewsCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsCategoryResource extends Resource
{
    protected static ?string $model = NewsCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Категорії новин';

    protected static ?string $modelLabel = 'категорія';

    protected static ?string $pluralModelLabel = 'Категорії новин';

    protected static ?string $navigationGroup = 'Новини';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name_ua')
                ->label('Назва (укр.)')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (string $context, $state, callable $set) {
                    if ($context === 'create') {
                        $set('slug', Str::slug($state));
                    }
                }),

            TextInput::make('name_en')
                ->label('Назва (англ.)')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->label('Slug (для посилань)')
                ->required()
                ->markAsRequired(false)
                ->maxLength(255)
                ->unique(ignoreRecord: true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ua')
                    ->label('Назва (укр.)')
                    ->searchable(),

                TextColumn::make('name_en')
                    ->label('Назва (англ.)')
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Slug'),

                TextColumn::make('news_count')
                    ->label('Новин')
                    ->counts('news'),
            ])
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(25);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsCategories::route('/'),
            'create' => Pages\CreateNewsCategory::route('/create'),
            'edit' => Pages\EditNewsCategory::route('/{record}/edit'),
        ];
    }
}
