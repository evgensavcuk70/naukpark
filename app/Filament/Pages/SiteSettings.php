<?php

// Filament-сторінка для редагування глобальних налаштувань сайту (контакти, соцмережі).
// На відміну від інших ресурсів, це не список записів, а одна форма "ключ → значення",
// тому реалізована як окрема Page, а не Resource.
namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Налаштування сайту';

    protected static ?string $title = 'Налаштування сайту';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.site-settings';

    public ?array $contactEmailData = [];

    public ?array $contactAddressUaData = [];

    public ?array $contactAddressEnData = [];

    public ?array $socialFacebookData = [];

    public ?array $socialLinkedinData = [];

    public ?array $socialTelegramData = [];

    public function mount(): void
    {
        $values = SiteSetting::allKeyed();

        $this->contactEmailForm->fill(['contact_email' => $values['contact_email'] ?? null]);
        $this->contactAddressUaForm->fill(['contact_address_ua' => $values['contact_address_ua'] ?? null]);
        $this->contactAddressEnForm->fill(['contact_address_en' => $values['contact_address_en'] ?? null]);
        $this->socialFacebookForm->fill(['social_facebook' => $values['social_facebook'] ?? null]);
        $this->socialLinkedinForm->fill(['social_linkedin' => $values['social_linkedin'] ?? null]);
        $this->socialTelegramForm->fill(['social_telegram' => $values['social_telegram'] ?? null]);
    }

    protected function getForms(): array
    {
        return [
            'contactEmailForm',
            'contactAddressUaForm',
            'contactAddressEnForm',
            'socialFacebookForm',
            'socialLinkedinForm',
            'socialTelegramForm',
        ];
    }

    public function contactEmailForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('contact_email')
                    ->label('Email')
                    ->email()
                    ->required(),
            ])
            ->statePath('contactEmailData');
    }

    public function contactAddressUaForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('contact_address_ua')
                    ->label('Адреса (укр.)')
                    ->required(),
            ])
            ->statePath('contactAddressUaData');
    }

    public function contactAddressEnForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('contact_address_en')
                    ->label('Адреса (англ.)')
                    ->required(),
            ])
            ->statePath('contactAddressEnData');
    }

    public function socialFacebookForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('social_facebook')
                    ->label('Facebook')
                    ->url(),
            ])
            ->statePath('socialFacebookData');
    }

    public function socialLinkedinForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('social_linkedin')
                    ->label('LinkedIn')
                    ->url(),
            ])
            ->statePath('socialLinkedinData');
    }

    public function socialTelegramForm(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('social_telegram')
                    ->label('Telegram')
                    ->url(),
            ])
            ->statePath('socialTelegramData');
    }

    protected function saveField(string $formName, string $key): void
    {
        $state = $this->{$formName}->getState();

        SiteSetting::set($key, trim((string) $state[$key]));

        Notification::make()
            ->title('Збережено')
            ->success()
            ->send();
    }

    public function saveContactEmail(): void
    {
        $this->saveField('contactEmailForm', 'contact_email');
    }

    public function saveContactAddressUa(): void
    {
        $this->saveField('contactAddressUaForm', 'contact_address_ua');
    }

    public function saveContactAddressEn(): void
    {
        $this->saveField('contactAddressEnForm', 'contact_address_en');
    }

    public function saveSocialFacebook(): void
    {
        $this->saveField('socialFacebookForm', 'social_facebook');
    }

    public function saveSocialLinkedin(): void
    {
        $this->saveField('socialLinkedinForm', 'social_linkedin');
    }

    public function saveSocialTelegram(): void
    {
        $this->saveField('socialTelegramForm', 'social_telegram');
    }
}
