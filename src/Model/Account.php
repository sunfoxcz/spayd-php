<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

interface Account
{
	public function __construct($accountString);

	public function isValid();

	public function getPrefix();

	public function getAccountNumber();

	public function getBankCode();
}