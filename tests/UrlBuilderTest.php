<?php

declare(strict_types=1);

use Ardenthq\UrlBuilder\Enums\Networks;
use Ardenthq\UrlBuilder\UrlBuilder;

it('should use default base url', function () {
    $builder = new UrlBuilder();

    $builder->setCoin('coin');
    $builder->setNethash('nethash');

    expect($builder->generateTransfer('recipient'))->toStartWith('https://app.arkvault.io/#/');
});

it('should use given base url', function () {
    $builder = new URLBuilder('baseUrl');

    $builder->setCoin('coin');
    $builder->setNethash('nethash');

    expect($builder->generateTransfer('recipient'))->toStartWith('baseUrl');
});

it('should set coin', function () {
    $builder = new URLBuilder();

    $builder->setCoin('coin');

    expect($builder->coin())->toBe('coin');
});

it('should set nethash', function () {
    $builder = new URLBuilder();

    $builder->setNethash('nethash');

    expect($builder->nethash())->toBe('nethash');
});

it('should set network', function () {
    $builder = new URLBuilder();

    $builder->setNetwork(Networks::ARKDevnet);

    expect($builder->nethash())->toBe(Networks::ARKDevnet->nethash());

    expect($builder->generateTransfer('recipient'))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=2a44f340d76ffc3df204c5f38cd355b7496c9065a1ade2ef92071436bd72e867');
});

it('should generate transfer url with memo', function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer('recipient', ['memo' => 'memo']))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&memo=memo');
});

it('should generate transfer url with amount', function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer('recipient', ['amount' => 1000]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&amount=1000');
});

it('should generate transfer url', function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer('recipient'))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
});

it('should not allow invalid amounts', function ($amount) {
    $builder = new URLBuilder();

    expect($builder->generateTransfer('recipient', ['amount' => $amount]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
})
->with([
    null,
    0,
    '1_4',
    '-1',
])
->throws(InvalidArgumentException::class);

it('should not allow invalid memo', function ($memo) {
    $builder = new URLBuilder();

    expect($builder->generateTransfer('recipient', ['memo' => $memo]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
})
->with([
    null,
    0,
    '',
])
->throws(InvalidArgumentException::class);
