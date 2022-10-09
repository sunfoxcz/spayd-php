<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

abstract class DefaultAccount implements Account
{
	protected string $accountString;

	protected string $locale;

	protected string $prefix = '';

	protected string $accountNumber;

	protected string $bankCode;

	/**
	 * @var array<int, string>
	 */
	protected array $localeAlphabet = [
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

	public function __construct(string $accountString, string $locale = NULL)
	{
		$this->accountString = $accountString;
		if (empty($locale) === true) {
			$this->locale = static::DEFAULT_LOCALE;
		} else {
			$this->locale = $locale;
		}

		$this->buildAccountParts();
	}

	public function getAccountString(): string
	{
		return $this->accountString;
	}
	
	public function getBankCode(): string
	{
		return $this->bankCode;
	}

	public function getAccountNumber(): string
	{
		return $this->accountNumber;
	}

	public function getPrefix(): string
	{
		return $this->prefix;
	}

	public function isValid(): bool
	{
		return (bool) preg_match($this->accountPattern, $this->accountString);
	}

	public function getLocale(): string
	{
		return $this->locale;
	}

	/**
	 * Returning numeric code of localization of account
	 */
	public function getNumericLanguageCode(): string
	{
		$numericLanguageCode = '';

		// step over each char from language code
		foreach(str_split($this->locale) as $char) {
			 // use the number for latin alphabet to decode
			 $numericLanguageCode .= array_search($char, $this->localeAlphabet);
		}

		return $numericLanguageCode . '00';
	}

	// method to build parts of the account
	abstract protected function buildAccountParts(): void;
}
