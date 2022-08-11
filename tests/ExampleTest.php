<?php

declare(strict_types=1);

use Ardenthq\UrlBuilder\Example;

test('example', function () {
    expect((new Example('value'))->getValue())->toBe('value');
});
