<?php

declare(strict_types=1);

namespace Ardenthq\UrlBuilder\Enums;

enum Methods
{
    case Transfer;

    public function name(): string
    {
        return match ($this) {
            Methods::Transfer => 'transfer',
        };
    }
}
