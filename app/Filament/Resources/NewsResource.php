<?php

// Filament-ресурс для управління новинами.
namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use App\Models\NewsCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Новини';

    protected static ?string $modelLabel = 'новина';

    protected static ?string $pluralModelLabel = 'Новини';

    protected static ?string $navigationGroup = 'Новини';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Основне')
                ->columns(2)
                ->schema([
                    Select::make('category_id')
                        ->label('Категорія')
                        ->options(fn () => NewsCategory::query()->pluck('name_ua', 'id'))
                        ->required()
                        ->searchable(),

                    TextInput::make('slug')
                        ->label('Slug (для посилання)')
                        ->required()
                        ->markAsRequired(false)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Латиницею, без пробілів. Генерується автоматично з укр. заголовку, можна змінити вручну.'),

                    FileUpload::make('image_main')
                        ->label('Головне зображення')
                        ->disk('public_images')
                        ->image()
                        ->imageEditor()
                        ->required()
                        ->visibility('public')
                        ->columnSpanFull(),

                    DatePicker::make('published_at')
                        ->label('Дата публікації')
                        ->default(now())
                        ->required(),

                    Toggle::make('is_pinned')
                        ->label('Закріпити на головній'),

                    Toggle::make('is_archived')
                        ->label('Архівна (прибрати з активного списку)'),
                ]),

            Tabs::make('Контент')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Українською')
                        ->schema([
                            TextInput::make('title_ua')
                                ->label('Заголовок')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $context, $state, callable $set) {
                                    if ($context === 'create') {
                                        $set('slug', News::generateSlug($state));
                                    }
                                }),

                            Textarea::make('excerpt_ua')
                                ->label('Короткий опис (анонс)')
                                ->required()
                                ->rows(3),

                            RichEditor::make('content_ua')
                                ->label('Текст новини')
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('meta_title_ua')
                                ->label('SEO заголовок (необов\'язково)')
                                ->maxLength(255),

                            Textarea::make('meta_description_ua')
                                ->label('SEO опис (необов\'язково)')
                                ->rows(2),
                        ]),

                    Tab::make('English')
                        ->schema([
                            TextInput::make('title_en')
                                ->label('Title')
                                ->required()
                                ->maxLength(255),

                            Textarea::make('excerpt_en')
                                ->label('Excerpt')
                                ->required()
                                ->rows(3),

                            RichEditor::make('content_en')
                                ->label('Content')
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('meta_title_en')
                                ->label('SEO title (optional)')
                                ->maxLength(255),

                            Textarea::make('meta_description_en')
                                ->label('SEO description (optional)')
                                ->rows(2),
                        ]),

                    Tab::make('Галерея')
                        ->schema([
                            FileUpload::make('gallery_images')
                                ->label('Додаткові фото')
                                ->disk('public_images')
                                ->image()
                                ->multiple()
                                ->visibility('public')
                                ->reorderable()
                                ->columnSpanFull()
                                ->helperText('Ці фото показуються в галереї новини на сайті.'),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_main')
                    ->label('Фото')
                    ->disk('public_images')
                    ->square(),

                TextColumn::make('title_ua')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('category.name_ua')
                    ->label('Категорія')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->date('d.m.Y')
                    ->sortable(),

                IconColumn::make('is_pinned')
                    ->label('Закріплена')
                    ->boolean(),

                IconColumn::make('is_archived')
                    ->label('Архів')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10)
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Категорія')
                    ->relationship('category', 'name_ua'),

                TernaryFilter::make('is_archived')
                    ->label('Архівні'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
