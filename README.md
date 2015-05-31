# spayd-php

SPAYD messages for QR code payments generation.

## Original author

Code is forked from [Shoptet/spayd-php](https://github.com/Shoptet/spayd-php) repository
just for [Packagist package](https://packagist.org/packages/sunfoxcz/spayd-php) generation.

## Example

```php
use Shoptet\Spayd\Spayd;
use Shoptet\Spayd\Model\CzechAccount;
use Shoptet\Spayd\Utilities\IbanUtilities;

$spayd = new Spayd;
$spayd->add('AM', $actuarial->price);
$spayd->add('CC', $actuarial->currency);
$spayd->add('X-VS', $actuarial->variableSymbol);

if ($actuarial->supplier->iban) {
	$spayd->add('ACC', "{$actuarial->supplier->iban}+{$actuarial->supplier->swift}");
} else {
	$account = new CzechAccount("{$actuarial->supplier->accountNumber}/{$actuarial->supplier->bankCode}");
	$spayd->add('ACC', IbanUtilities::computeIbanFromBankAccount($account));
}

echo (string) $spayd;
```
