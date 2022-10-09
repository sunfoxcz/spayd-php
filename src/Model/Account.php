<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

interface Account
{
	public function __construct(string $accountString);

	public function isValid(): bool;

	public function getPrefix(): string;

	public function getAccountNumber(): string;

	public function getBankCode(): string;
}
