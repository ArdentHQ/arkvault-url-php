<?php

declare(strict_types=1);

use Ardenthq\UrlBuilder\Enums\Networks;
use Ardenthq\UrlBuilder\UrlBuilder;

it("should use default base url", function() {
    $builder = new UrlBuilder();

    $builder->setCoin("coin");
    $builder->setNethash("nethash");

    expect($builder->generateTransfer("recipient"))->toStartWith('https://app.arkvault.io/#/');
});

it("should use given base url", function () {
    $builder = new URLBuilder('baseUrl');

    $builder->setCoin("coin");
    $builder->setNethash("nethash");

    expect($builder->generateTransfer("recipient"))->toStartWith('baseUrl');
});

it("should set coin", function () {
    $builder = new URLBuilder();

    $builder->setCoin("coin");

    expect($builder->coin())->toBe("coin");
});

it("should set nethash", function () {
    $builder = new URLBuilder();

    $builder->setNethash("nethash");

    expect($builder->nethash())->toBe("nethash");
});

it("should set nethash from preset", function () {
    $builder = new URLBuilder();

    $builder->setNethashFromPreset(Networks::ARKMainnet);

    expect($builder->nethash())->toBe(Networks::ARKMainnet->nethash());
});


it("should generate transfer url with memo", function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer("recipient", ['memo' => 'memo']))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&memo=memo');
});

it("should generate transfer url with amount", function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer("recipient", ['amount' => 1000]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&amount=1000');
});

it("should generate transfer url", function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer("recipient"))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
});

it("should not include amount & memo options if they are falsy", function () {
    $builder = new URLBuilder();

    expect($builder->generateTransfer("recipient", ['amount' => null, 'memo' => null]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
    
    expect($builder->generateTransfer("recipient", ['amount' => '', 'memo' => '']))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988');
});
