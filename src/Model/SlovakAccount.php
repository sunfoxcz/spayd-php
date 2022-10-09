<?php declare(strict_types=1);

namespace Sunfox\Spayd\Model;

final class SlovakAccount extends DefaultAccount
{
	protected string $accountPattern = '~^
		(?:
			(?P<prefix>\d{0,6})
			(?:\-{1}) # prefix delimiter
		){0,1}
		(?:
			(?P<accountNumber>\d{2,10})
			(?:\/{1}) # bank code delimiter
			(?P<bankCode>\d{3,4}|[A-Z]{4,7})
		)
		$~Dix';

	public function __construct(string $accountString)
	{
		parent::__construct($accountString, 'CZ');
		$this->buildAccountParts($accountString);
	}

	protected function buildAccountParts(string $accountString): void
	{
		$this->isValid = (bool) preg_match($this->accountPattern, $accountString, $accountParts);

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
