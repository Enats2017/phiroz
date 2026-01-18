<?php
final class Encryption
{
	private $key;
	private $iv;

	public function __construct($key)
	{
		$this->key = hash('sha256', $key, true);
		$this->iv = str_repeat("\0", 16); // Dummy IV for compatibility
	}

	public function encrypt($value)
	{
		if (function_exists('openssl_encrypt')) {
			return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(openssl_encrypt($value, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv)));
		} else {
			return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($value)); // Fallback (No Encryption)
		}
	}

	public function decrypt($value)
	{
		if (function_exists('openssl_decrypt')) {
			$value = str_replace(array('-', '_'), array('+', '/'), $value);
			$decrypted = openssl_decrypt(base64_decode($value), 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
			return $decrypted !== false ? trim($decrypted) : '';
		} else {
			return base64_decode(str_replace(array('-', '_'), array('+', '/'), $value)); // Fallback
		}
	}
}
?>