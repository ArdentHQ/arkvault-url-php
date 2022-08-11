<?php

namespace Ardenthq\UrlBuilder\Enums;

enum Networks
{
    case ARKDevnet;

    case ARKMainnet;

    public function nethash(): string
    {
        return match($this) 
        {
            Networks::ARKDevnet => '2a44f340d76ffc3df204c5f38cd355b7496c9065a1ade2ef92071436bd72e867',   
            Networks::ARKMainnet => '6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988',   
        };
    }
}
