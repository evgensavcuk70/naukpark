<?php

// Filament-ресурс для управління напрямами діяльності.
namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Support\ContentLimits;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Напрями діяльності';

    protected static ?string $modelLabel = 'напрям діяльності';

    protected static ?string $pluralModelLabel = 'Напрями діяльності';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('icon_path')
                ->label('Іконка')
                ->disk('public_images')
                ->image()
                ->visibility('public')
                ->required()
                ->columnSpanFull(),

            Tabs::make('Контент')
                ->columnSpanFull()
                ->tabs([
                    Tab::make('Українською')
                        ->schema([
                            TextInput::make('title_ua')
                                ->label('Назва')
                                ->required()
                                ->maxLength(ContentLimits::ACTIVITY_TITLE_MAX)
                                ->helperText('Не більше ' . ContentLimits::ACTIVITY_TITLE_MAX . ' символів.'),

                            Textarea::make('description_ua')
                                ->label('Опис')
                                ->required()
                                ->maxLength(ContentLimits::ACTIVITY_DESCRIPTION_MAX)
                                ->helperText('Не більше ' . ContentLimits::ACTIVITY_DESCRIPTION_MAX . ' символів.')
                                ->rows(4),
                        ]),

                    Tab::make('English')
                        ->schema([
                            TextInput::make('title_en')
                                ->label('Title')
                                ->required()
                                ->maxLength(ContentLimits::ACTIVITY_TITLE_MAX)
                                ->helperText('Maximum ' . ContentLimits::ACTIVITY_TITLE_MAX . ' characters.'),

                            Textarea::make('description_en')
                                ->label('Description')
                                ->required()
                                ->maxLength(ContentLimits::ACTIVITY_DESCRIPTION_MAX)
                                ->helperText('Maximum ' . ContentLimits::ACTIVITY_DESCRIPTION_MAX . ' characters.')
                                ->rows(4),
                        ]),
                ]),

            TextInput::make('sort_order')
                ->label('Порядок сортування')
                ->numeric()
                ->default(0)
                ->required(),

            Toggle::make('is_visible')
                ->label('Показувати на сайті')
                ->default(true)
                ->helperText('Максимум ' . Activity::maxActiveRecords() . ' активних напрямів одночасно.')

                ->rule(function (Get $get, ?Activity $record) {
                    return function (string $attribute, $value, callable $fail) use ($record) {
                        if (!$value) {
                            return;
                        }

                        if (!Activity::canActivateAnother($record?->id)) {
                            $fail('Досягнуто максимум ' . Activity::maxActiveRecords() . ' активних напрямів. Спочатку приховайте або видаліть інший запис.');
                        }
                    };
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon_path')
                    ->label('Іконка')
                    ->disk('public_images')
                    ->square(),

                TextColumn::make('title_ua')
                    ->label('Назва (укр.)')
                    ->searchable(),

                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),

                ToggleColumn::make('is_visible')
                    ->label('Видимий')

                    ->beforeStateUpdated(function (Activity $record, $state) {
                        if ($state && !Activity::canActivateAnother($record->id)) {
                            Notification::make()
                                ->title('Перевищено ліміт активних напрямів')
                                ->body('Максимум ' . Activity::maxActiveRecords() . ' активних записів. Спочатку приховайте інший напрям.')
                                ->danger()
                                ->send();

                            throw ValidationException::withMessages([
                                'is_visible' => 'Досягнуто максимум ' . Activity::maxActiveRecords() . ' активних напрямів.',
                            ]);
                        }
                    }),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')

            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
