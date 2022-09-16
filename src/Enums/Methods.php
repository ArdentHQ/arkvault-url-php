<?php

declare(strict_types=1);

namespace Ardenthq\UrlBuilder\Enums;

enum Methods
{
    case Transfer;

    case Vote;

    case Sign;

    case Verify;

    public function name(): string
    {
        return match ($this) {
            Methods::Transfer => 'transfer',
            Methods::Vote     => 'vote',
            Methods::Sign     => 'sign',
            Methods::Verify   => 'verify',
        };
    }
}
