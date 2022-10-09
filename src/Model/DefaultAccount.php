<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

abstract class DefaultAccount implements Account
{
	protected string $accountString;

	protected string $locale;

	protected string $prefix = '';

	protected string $accountNumber;

	protected string $bankCode;

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

	// method to build parts of the account
	abstract protected function buildAccountParts(): void;
}
