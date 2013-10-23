<?php
namespace Shoptet\Spayd\Model;
use Shoptet\Spayd\Model;

class CzechAccount extends DefaultAccount {

	const PREFIX_DELIMITER = '-';
	const BANK_CODE_DELIMITER = '/';
	
	protected $regularExpression = '~^(?P<prefixPart>(?P<prefix>\d{0,6})(?P<prefixDelimiter>\-{1})){0,1}(?P<accountPart>(?P<accountNumber>\d{2,10})(?P<bankCodeDelimiter>\/{1})(?P<bankCode>\d{3,4}))$~';
	
	protected function buildAccountParts() {
		preg_match($this->regularExpression, $this->accountString, $accountParts);
		if (empty($accountParts['prefix']) === FALSE) {
			$this->prefix = $accountParts['prefix'];
		}
		
		if (empty($accountParts['accountNumber']) === FALSE) {
			$this->accountNumber = $accountParts['accountNumber'];
		}
		
		if (empty($accountParts['bankCode']) === FALSE) {
			$this->bankCode = $accountParts['bankCode'];
		}
	}
}