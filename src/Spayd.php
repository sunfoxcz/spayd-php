<?php declare(strict_types=1);

namespace Sunfox\Spayd;

use Sunfox\Spayd\Exceptions\InvalidParameterException;

class Spayd
{
	const BINARY_QR_REGEXP = '[0-9A-Z $%*+-./:]';
	// Spayd part delimiter
	const DELIMITER = '*';
	// key, value delimiter
	const KV_DELIMITER = ':';

	public bool $appendCRC32 = true;

	// default Spayd string version
	protected string $version = '1.0';

	/**
	 * @var array<string, string>
	 */
	private array $content = [];

	/**
	 * @var array<string, string>
	 */
	private array $keysDefinition = [
		// Account in IBAN format plus optional SWIFT
		'ACC' => '[A-Z]{2}\d{2,32}(\+[A-Z0-9]{4}[A-Z]{2}[A-Z0-9]{2,5})?',

		// One or two alternative accounts in the ACC format
		'ALT-ACC' => '[A-Z]{2}\d{2,32}(\+[A-Z0-9]{4}[A-Z]{2}[A-Z0-9]{2,5})?(,[A-Z]{2}\d{2,32}(\+[A-Z0-9]{4}[A-Z]{2}[A-Z0-9]{2,5})?)?',

		// Amount
		'AM' => '^[0-9]{0,10}(\\.[0-9]{0,2})?$',

		// Currency ISO 4217
		'CC' => '[A-Z]{3}',

		// Identificator
		'RF' => '\d{1,16}',

		// Name
		'RN' => '[0-9A-Z $%+-./:]{1,35}',

		// Date ISO 8601
		'DT' => '[12]\d{3}[01]\d[0-3]\d',

		// Type of payment
		'PT' => '[0-9A-Z $%+-./:]{1,3}',

		// Message
		'MSG' => '[0-9A-Z $%+-./:]{1,60}',

		// Control sum
		'CRC32' => '[A-F0-9]{8}',

		// Contact channel flag. P - phone, E - email
		'NT' => '[PE]',

		// Contact information. Either phone (00420123456789 or +420123456789) or email.
		// TODO: better email regexp
		'NTA' => '((\+|00)\'{12}|.+@.+\..+)',

		// Expanded params for use in Czech Republic
		'X-PER' => '\d{1,2}',
		'X-VS' => '\d{1,10}',
		'X-SS' => '\d{1,10}',
		'X-KS' => '\d{1,10}',
		'X-ID' => '[0-9A-Z $%+-./:]{1,20}',
		'X-URL' => '[0-9A-Z $%+-./:]{1,140}',
	];

	public function __construct()
	{
	}

	public function getVersion(): string
	{
		return $this->version;
	}

	public function setVersion(string $version): self
	{
		if (!preg_match('~^\d\.\d$~', $version)) {
			throw new InvalidParameterException(
				"Version $version is not valid."
			);
		}

		$this->version = $version;
		return $this;
	}

	public function add(string $key, string $value): self
	{
		$key = $this->normalizeKey($key);
		if (strpos($key, 'X-') !== 0 && !isset($this->keysDefinition[$key])) {
			throw new InvalidParameterException("Key $key is not defined in specification.");
		}

		if (
			isset($this->keysDefinition[$key]) &&
			!preg_match('~^' . $this->keysDefinition[$key] . '$~', $value)
		) {
			throw new InvalidParameterException(
				"Key $key with value $value doesn't match defined format: "
				. $this->keysDefinition[$key]
			);
		}

		$this->content[$key] = $value;
		return $this;
	}

	public function delete(string $key): self
	{
		unset($this->content[$this->normalizeKey($key)]);
		return $this;
	}

	public function generate(): string
	{
		$spayd = 'SPD'
			. self::DELIMITER
			. $this->getVersion()
			. self::DELIMITER
			. $this->implodeContent();

		if ($this->appendCRC32) {
			$spayd .= '*CRC32:' . sprintf('%x', crc32($spayd));
		}

		return $spayd;
	}

	public function __toString(): string
	{
		return $this->generate();
	}

	private function normalizeKey(string $key): string
	{
		return strtoupper($key);
	}

	private function implodeContent(): string
	{
		ksort($this->content);
		$output = '';
		foreach ($this->content as $key => $value) {
			$output .= $key . self::KV_DELIMITER . $value . self::DELIMITER;
		}

		return rtrim($output, self::DELIMITER);
	}
}
