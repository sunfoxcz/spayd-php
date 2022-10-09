<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

class CzechAccount extends DefaultAccount
{
	const DEFAULT_LOCALE = 'CZ';
	const PREFIX_DELIMITER = '-';
	const BANK_CODE_DELIMITER = '/';
	
	protected $accountPattern = '~^(?P<prefixPart>(?P<prefix>\d{0,6})(?P<prefixDelimiter>\-{1})){0,1}(?P<accountPart>(?P<accountNumber>\d{2,10})(?P<bankCodeDelimiter>\/{1})(?P<bankCode>\d{3,4}))$~';
	
	protected function buildAccountParts()
	{
		preg_match($this->accountPattern, $this->accountString, $accountParts);
		if (empty($accountParts['prefix']) === false) {
			$this->prefix = $accountParts['prefix'];
		}

		if (empty($accountParts['accountNumber']) === false) {
			$this->accountNumber = $accountParts['accountNumber'];
		}

		if (empty($accountParts['bankCode']) === false) {
			$this->bankCode = $accountParts['bankCode'];
		}
	}
}
