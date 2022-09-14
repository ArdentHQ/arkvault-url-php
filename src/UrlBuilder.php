<?php

declare(strict_types=1);

namespace Ardenthq\UrlBuilder;

use Ardenthq\UrlBuilder\Enums\Methods;
use Ardenthq\UrlBuilder\Enums\Networks;
use InvalidArgumentException;

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

    public function setNetwork(Networks | string $network):self
    {
        $this->nethash = $network instanceof Networks ? $network->nethash() : $network;

        return $this;
    }

    public function generateTransfer(string $recipient, array $options = []): string
    {
        $this->validateOptions($options);

        $options = [
            'method'    => Methods::Transfer->name(),
            'recipient' => $recipient,
            ...array_filter($options),
        ];

        return $this->generateUrl($options);
    }

    public function generateVote(string $subject): string
    {
        $options = [
            'method' => Methods::Vote->name(),
        ];

        if (strlen($subject) === 66) {
            $options['publicKey'] = $subject;
        } else {
            $options['delegate'] = $subject;
        }

        return $this->generateUrl($options);
    }

	public function generateMessageSign(string $message, array $options = []): string
	{
		if (!$message) {
			throw new InvalidArgumentException("Message is required");
		}

		$options = [
            'method'    => Methods::Sign->name(),
            'message' => $message,
            ...array_filter($options),
        ];

		return $this->generateUrl($options);
	}

	// public function generateMessageVerify({ message, signatory, signature }: SignedMessage) {
	// 	if (!message || !signatory || !signature) {
	// 		throw new Error("signed message is invalid");
	// 	}

	// 	return this.#generate({
	// 		message,
	// 		method: Methods.Verify,
	// 		signatory,
	// 		signature,
	// 	});
	// }

    private function generateUrl(array $options): string
    {
		$options = [
			'coin' => $this->coin,
			'nethash' => $this->nethash,
			...$options,
		];

        $queryString = http_build_query($options);

        return sprintf('%s?%s', $this->baseUrl, $queryString);
    }

    private function validateOptions(array $options)
    {
        if (array_key_exists('amount', $options)) {
            if (! is_numeric($options['amount'])) {
                throw new InvalidArgumentException('Amount must be a number');
            }

            if (floatval($options['amount']) <= 0) {
                throw new InvalidArgumentException('Amount must be a positive number');
            }
        }

        if (array_key_exists('memo', $options)) {
            if (! is_string($options['memo'])) {
                throw new InvalidArgumentException('Memo must be a string');
            }

            if ($options['memo'] === '') {
                throw new InvalidArgumentException('Memo must not be empty');
            }
        }
    }
}
