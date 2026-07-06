<?php

// Filament-ресурс для управління слайдами головного слайдера сайту.
namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Models\Slide;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Validation\ValidationException;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Слайди';

    protected static ?string $modelLabel = 'слайд';

    protected static ?string $pluralModelLabel = 'Слайди головної сторінки';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('image_path')
                ->label('Зображення')
                ->disk('public_images')
                ->image()
                ->imageEditor()
                ->required()
                ->visibility('public')
                ->columnSpanFull(),

            TextInput::make('title_ua')
                ->label('Заголовок (укр.)')
                ->required()
                ->maxLength(255),

            TextInput::make('title_en')
                ->label('Заголовок (англ.)')
                ->required()
                ->maxLength(255),

            TextInput::make('sort_order')
                ->label('Порядок сортування')
                ->numeric()
                ->default(0)
                ->required(),

            Toggle::make('is_active')
                ->label('Активний (показувати на сайті)')
                ->default(true)
                ->helperText('Максимум ' . Slide::maxActiveRecords() . ' активних слайдів одночасно.')

                ->rule(function (?Slide $record) {
                    return function (string $attribute, $value, callable $fail) use ($record) {
                        if (!$value) {
                            return;
                        }

                        if (!Slide::canActivateAnother($record?->id)) {
                            $fail('Досягнуто максимум ' . Slide::maxActiveRecords() . ' активних слайдів. Спочатку деактивуйте або видаліть інший слайд.');
                        }
                    };
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Зображення')
                    ->disk('public_images')
                    ->square(),

                TextColumn::make('title_ua')
                    ->label('Заголовок (укр.)')
                    ->searchable(),

                TextColumn::make('title_en')
                    ->label('Заголовок (англ.)')
                    ->searchable(),

                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Активний')

                    ->beforeStateUpdated(function (Slide $record, $state) {
                        if ($state && !Slide::canActivateAnother($record->id)) {
                            Notification::make()
                                ->title('Перевищено ліміт активних слайдів')
                                ->body('Максимум ' . Slide::maxActiveRecords() . ' активних слайдів. Спочатку деактивуйте інший слайд.')
                                ->danger()
                                ->send();

                            throw ValidationException::withMessages([
                                'is_active' => 'Досягнуто максимум ' . Slide::maxActiveRecords() . ' активних слайдів.',
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
