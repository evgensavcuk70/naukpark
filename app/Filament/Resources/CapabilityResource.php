<?php

// Filament-ресурс для управління можливостями (Capabilities).
namespace App\Filament\Resources;

use App\Filament\Resources\CapabilityResource\Pages;
use App\Models\Capability;
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

class CapabilityResource extends Resource
{
    protected static ?string $model = Capability::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationLabel = 'Можливості';

    protected static ?string $modelLabel = 'можливість';

    protected static ?string $pluralModelLabel = 'Можливості';

    protected static ?int $navigationSort = 4;

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
                                ->maxLength(255),

                            Textarea::make('description_ua')
                                ->label('Опис')
                                ->required()
                                ->maxLength(ContentLimits::CAPABILITY_DESCRIPTION_MAX)
                                ->helperText('Не більше ' . ContentLimits::CAPABILITY_DESCRIPTION_MAX . ' символів.')
                                ->rows(4),
                        ]),

                    Tab::make('English')
                        ->schema([
                            TextInput::make('title_en')
                                ->label('Title')
                                ->required()
                                ->maxLength(255),

                            Textarea::make('description_en')
                                ->label('Description')
                                ->required()
                                ->maxLength(ContentLimits::CAPABILITY_DESCRIPTION_MAX)
                                ->helperText('Maximum ' . ContentLimits::CAPABILITY_DESCRIPTION_MAX . ' characters.')
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
                ->helperText('Максимум ' . Capability::maxActiveRecords() . ' активних можливостей одночасно.')

                ->rule(function (Get $get, ?Capability $record) {
                    return function (string $attribute, $value, callable $fail) use ($record) {
                        if (!$value) {
                            return;
                        }

                        if (!Capability::canActivateAnother($record?->id)) {
                            $fail('Досягнуто максимум ' . Capability::maxActiveRecords() . ' активних можливостей. Спочатку приховайте або видаліть інший запис.');
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
                    ->label('Видима')

                    ->beforeStateUpdated(function (Capability $record, $state) {
                        if ($state && !Capability::canActivateAnother($record->id)) {
                            Notification::make()
                                ->title('Перевищено ліміт активних можливостей')
                                ->body('Максимум ' . Capability::maxActiveRecords() . ' активних записів. Спочатку приховайте інший запис.')
                                ->danger()
                                ->send();

                            throw ValidationException::withMessages([
                                'is_visible' => 'Досягнуто максимум ' . Capability::maxActiveRecords() . ' активних можливостей.',
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
            'index' => Pages\ListCapabilities::route('/'),
            'create' => Pages\CreateCapability::route('/create'),
            'edit' => Pages\EditCapability::route('/{record}/edit'),
        ];
    }
}
