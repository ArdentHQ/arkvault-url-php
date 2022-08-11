<?php

declare(strict_types=1);

namespace Ardenthq\UrlBuilder;

use Ardenthq\UrlBuilder\Enums\Methods;
use Ardenthq\UrlBuilder\Enums\Networks;

class UrlBuilder
{
    private string $coin = 'ARK';

    private string $nethash;

    public function __construct(public string $baseUrl = 'https://app.arkvault.io/#/')
    {
        $this->nethash = Networks::ARKMainnet->nethash();
    }

    public function coin(): string
    {
        return $this->coin;
    }

    public function setCoin(string $coin): self
    {
        $this->coin = $coin;

        return $this;
    }

    public function nethash(): string
    {
        return $this->nethash;
    }

    public function setNetwork(Networks $network):self
    {
        $this->nethash = $network->nethash();

        return $this;
    }

    public function setNethash(string $nethash): self
    {
        $this->nethash = $nethash;

        return $this;
    }

    public function generateTransfer(string $recipient, array $options = []): string
    {
        $options = [
            'method'    => Methods::Transfer->method(),
            'recipient' => $recipient,
            'coin'      => $this->coin,
            'nethash'   => $this->nethash,
            ...array_filter($options),
        ];

        $queryString = http_build_query($options);

        return sprintf('%s?%s', $this->baseUrl, $queryString);
    }
}
