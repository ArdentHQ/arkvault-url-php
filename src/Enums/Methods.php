<?php

namespace Ardenthq\UrlBuilder\Enums;

enum Methods
{
    case Transfer;

    public function method(): string
    {
        return match($this) 
        {
            Methods::Transfer => 'transfer',   
        };
    }
}
