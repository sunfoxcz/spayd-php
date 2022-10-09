<?php declare(strict_types=1);

namespace SunfoxTests\Spayd\Cases;

use Sunfox\Spayd\Spayd;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class SpaydTest extends Tester\TestCase
{
	public function testGenerate(): void
	{
		$spayd = new Spayd;
		$spayd->add('AM', '1200.00');
		$spayd->add('CC', 'CZK');
		$spayd->add('X-VS', '123456789');
		$spayd->add('ACC', "CZ4101000000001234567901+KOMBCZPP");

		//$account = new CzechAccount("{$actuarial->supplier->accountNumber}/{$actuarial->supplier->bankCode}");
		//$spayd->add('ACC', IbanUtilities::computeIbanFromBankAccount($account));

		Assert::same(
			'SPD*1.0*ACC:CZ4101000000001234567901+KOMBCZPP*AM:1200.00*CC:CZK*X-VS:123456789*CRC32:5296924',
			(string) $spayd
		);
	}
}

(new SpaydTest)->run();
