<?php declare(strict_types=1);

namespace SunfoxTests\Spayd\Cases;

use Sunfox\Spayd\Model\CzechAccount;
use Sunfox\Spayd\Utilities\IbanUtilities;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class IbanUtilitiesTest extends Tester\TestCase
{
	public function testComputeIban(): void
	{
		$account = new CzechAccount("1234567901/0100");
		$iban = IbanUtilities::computeIbanFromBankAccount($account);

		Assert::same('CZ4101000000001234567901', $iban);
	}

	public function testComputeIbanWithAccountPrefix(): void
	{
		$account = new CzechAccount("123457-1234567901/0100");
		$iban = IbanUtilities::computeIbanFromBankAccount($account);

		Assert::same('CZ7401001234571234567901', $iban);
	}
}

(new IbanUtilitiesTest)->run();
