<?php

declare(strict_types=1);

use Ardenthq\UrlBuilder\Enums\Networks;
use Ardenthq\UrlBuilder\UrlBuilder;

it('should use default base url', function () {
    $builder = new UrlBuilder();

    expect($builder->generateTransfer('recipient'))->toStartWith('https://app.arkvault.io/#/');
});

it('should use given base url', function () {
    $builder = new URLBuilder('baseUrl');

    expect($builder->generateTransfer('recipient'))->toStartWith('baseUrl');
});

it('should set coin', function () {
    $builder = new URLBuilder();

    $builder->setCoin('coin');

    expect($builder->coin())->toBe('coin');
});

it('should set network with nethash', function () {
    $builder = new URLBuilder();

    $builder->setNetwork('nethash');

    expect($builder->nethash())->toBe('nethash');
});

it('should set network with enum', function () {
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

it('encodes the memo', function () {
    $builder = new URLBuilder();

    $memo = <<<'EOT'
This is a memo with newlines

and special characters like äöüß

It should be encoded correctly.
EOT;

    expect($builder->generateTransfer('recipient', ['memo' => $memo]))
        ->toBe('https://app.arkvault.io/#/?method=transfer&recipient=recipient&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&memo=This+is+a+memo+with+newlines%0A%0Aand+special+characters+like+%C3%A4%C3%B6%C3%BC%C3%9F%0A%0AIt+should+be+encoded+correctly.');
});

it('should generate a vote url from delegate', function () {
    $builder = new UrlBuilder();

    expect($builder->generateVote('benchdark'))->toBe('https://app.arkvault.io/#/?method=vote&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&delegate=benchdark');
});

it('should generate a vote url from delegate public key', function () {
    $builder = new UrlBuilder();

    expect($builder->generateVote('0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1'))->toBe('https://app.arkvault.io/#/?method=vote&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&publicKey=0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1');
});

it('should generate a vote url on a different network', function () {
    $builder = new UrlBuilder();

    $builder->setNetwork(Networks::ARKDevnet);

    expect($builder->generateVote('benchdark'))->toBe('https://app.arkvault.io/#/?method=vote&coin=ARK&nethash=2a44f340d76ffc3df204c5f38cd355b7496c9065a1ade2ef92071436bd72e867&delegate=benchdark');
});
