<?php declare(strict_types=1);

namespace Sunfox\Spayd\Utilities;

use Sunfox\Spayd\Model\DefaultAccount;

final class IbanUtilities
{
	/**
	 * @var array<int, string>
	 */
	const LOCALE_ALPHABET = [
		10 => 'A',
		11 => 'B',
		12 => 'C',
		13 => 'D',
		14 => 'E',
		15 => 'F',
		16 => 'G',
		17 => 'H',
		18 => 'I',
		19 => 'J',
		20 => 'K',
		21 => 'L',
		22 => 'M',
		23 => 'N',
		24 => 'O',
		25 => 'P',
		26 => 'Q',
		27 => 'R',
		28 => 'S',
		29 => 'T',
		30 => 'U',
		31 => 'V',
		32 => 'W',
		33 => 'X',
		34 => 'Y',
		35 => 'Z',
	];

	public static function computeIbanFromBankAccount(DefaultAccount $account): ?string
	{
		if ($account->isValid()) {
			$prefix = str_pad($account->getPrefix(), 6, '0', STR_PAD_LEFT);
			$accountNumber = str_pad($account->getAccountNumber(), 10, '0', STR_PAD_LEFT);
			$bankCode = str_pad($account->getBankCode(), 4, '0', STR_PAD_LEFT);

			$accountBuffer = $bankCode . $prefix . $accountNumber . self::getNumericLanguageCode($account->getLocale());
			$checksum = sprintf('%02d', (98 - bcmod($accountBuffer, '97')));

			// build the IBAN number
			return $account->getLocale() . $checksum . $bankCode . $prefix . $accountNumber;
		}

		return null;
	}

	/**
	 * Returning numeric code of localization of account
	 */
	private static function getNumericLanguageCode(string $locale): string
	{
		$numericLanguageCode = '';

		// step over each char from language code
		foreach(str_split($locale) as $char) {
			// use the number for latin alphabet to decode
			$numericLanguageCode .= array_search($char, self::LOCALE_ALPHABET);
		}

		return $numericLanguageCode . '00';
	}
}
