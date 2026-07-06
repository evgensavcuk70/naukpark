<?php

// Єдине джерело істини для лімітів довжини текстових полів.
// Filament Resources, моделі та будь-яка інша валідація мають посилатись на ці константи
// замість того, щоб повторювати числа 60/180/120 у кожному місці окремо.
namespace App\Support;

final class ContentLimits
{

    public const ACTIVITY_TITLE_MAX = 60;

    public const ACTIVITY_DESCRIPTION_MAX = 180;

    public const CAPABILITY_DESCRIPTION_MAX = 120;

    private function __construct()
    {

    }
}
