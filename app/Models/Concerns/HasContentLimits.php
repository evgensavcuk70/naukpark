<?php

// Спільні правила валідації для моделей контенту з обмеженою кількістю активних записів
// (Activity, Capability, Slide).
// Єдине джерело істини для лімітів довжини полів та максимальної кількості записів,
// щоб однакові цифри не дублювались окремо в моделі, Filament Resource та валідації форми.
namespace App\Models\Concerns;

trait HasContentLimits
{

    public static function maxActiveRecords(): int
    {
        return 10;
    }

    public static function visibilityColumn(): string
    {
        return 'is_visible';
    }

    public static function activeCount(): int
    {
        return static::query()
            ->where(static::visibilityColumn(), true)
            ->count();
    }

    public static function canActivateAnother(?int $excludingId = null): bool
    {
        $query = static::query()->where(static::visibilityColumn(), true);

        if ($excludingId !== null) {
            $query->where('id', '!=', $excludingId);
        }

        return $query->count() < static::maxActiveRecords();
    }
}
