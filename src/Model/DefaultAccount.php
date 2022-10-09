<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

abstract class DefaultAccount implements Account
{
	protected bool $isValid = false;

	protected string $accountString = '';

	protected string $locale = '';

	protected string $prefix = '';

	protected string $accountNumber = '';

	protected string $bankCode = '';

	public function __construct(string $accountString, string $locale)
	{
		$this->accountString = $accountString;
		$this->locale = $locale;
	}

	public function isValid(): bool
	{
		return $this->isValid;
	}

	public function getPrefix(): string
	{
		return $this->prefix;
	}

	public function getAccountNumber(): string
	{
		return $this->accountNumber;
	}

	public function getBankCode(): string
	{
		return $this->bankCode;
	}

	public function getLocale(): string
	{
		return $this->locale;
	}
}
