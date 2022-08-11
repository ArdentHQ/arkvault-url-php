# ARKVault URL

<p align="center">
    <img src="./banner.png" />
</p>

> A PHP package to generate URLs compatible with ARKVault

## Usage

Install the package in your project

```bash
composer require ardenthq/arkvault-url-php
```

Import the URLBuilder class

```php
use Ardenthq\UrlBuilder\UrlBuilder;
```

Initiate the builder and generate your URL

```php
$builder = new UrlBuilder();

$transferUrl = $builder->generateTransfer('DM7UiH4b2rW2Nv11Wu6ToiZi8MJhGCEWhP');
// > https://app.arkvault.io/#/?method=transfer&recipient=DM7UiH4b2rW2Nv11Wu6ToiZi8MJhGCEWhP&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988

$transferUrl = $builder->generateTransfer('DM7UiH4b2rW2Nv11Wu6ToiZi8MJhGCEWhP', [
  'amount' => 12.50,
  'memo' => 'My custom message'
]);
// > https://app.arkvault.io/#/?method=transfer&recipient=DM7UiH4b2rW2Nv11Wu6ToiZi8MJhGCEWhP&coin=ARK&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&amount=12.5&memo=My+custom+message

$voteUrl = $builder->generateVote('benchdark');
// > https://app.arkvault.io/#/?method=vote&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&delegate=benchdark

$voteUrl = $builder->generateVote('0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1');
// > https://app.arkvault.io/#/?method=vote&nethash=6e84d08bd299ed97c212c886c98a57e36545c8f5d645ca7eeae63a8bd62d8988&publicKey=0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1
```

For further customizations, you can use the following methods

```php
// Custom coin
$builder->setCoin("Custom"); // Defaults to "ARK"

// Pass a custom nethash for the network
$builder->setNetwork("0123..ef)"; // Defaults to ARK's mainnet nethash

// Or pass the network using the `Networks` enum
// Import enum: `use Ardenthq\UrlBuilder\Enums\Networks;`
$builder->setNetwork(Networks::ARKDevnet);

// Change the base URL by passing it into the constructor
new URLBuilder("https://your-url.com"); // Defaults to app.arkvault.io
```

## Development

[pnpm](https://pnpm.js.org/en/) is required to be installed before starting. It is used to manage this repo.

### Analyze the code with `phpstan`

```bash
composer analyse
```

### Refactor the code with php `rector`

```bash
composer refactor
```

### Format the code with `php-cs-fixer`

```bash
composer format
```

### Run tests

```bash
composer test
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to security@ardenthq.com. All security vulnerabilities will be promptly addressed.

## Credits

This project exists thanks to all the people who [contribute](../../contributors).

## License

[MIT](LICENSE) © [Ardent](https://ardenthq.com)
