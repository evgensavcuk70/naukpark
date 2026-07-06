<x-filament-panels::page>
    <x-filament::section heading="Контактна інформація">
        <div class="space-y-6">
            <form wire:submit="saveContactEmail" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->contactEmailForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>

            <form wire:submit="saveContactAddressUa" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->contactAddressUaForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>

            <form wire:submit="saveContactAddressEn" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->contactAddressEnForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>

    <x-filament::section heading="Соціальні мережі">
        <div class="space-y-6">
            <form wire:submit="saveSocialFacebook" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->socialFacebookForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>

            <form wire:submit="saveSocialLinkedin" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->socialLinkedinForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>

            <form wire:submit="saveSocialTelegram" class="flex items-end gap-4">
                <div class="flex-1">
                    {{ $this->socialTelegramForm }}
                </div>
                <x-filament::button type="submit">
                    Зберегти
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-panels::page>
