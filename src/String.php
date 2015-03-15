<?php

namespace Phalconry\StdLib;

use Phalcon\Text;

class String
{
	
	const CASE_LOWER = 0;
	const CASE_UPPER = 1;
	const CASE_TITLE = 2;
	const PAD_LEFT = 0;
	const PAD_RIGHT = 1;
	const PAD_BOTH = 2;
	
	const STRING = 13;
	const URL = 15;
	const EMAIL = 17;
	const REGEXP = 19;
	
	const ERROR_IGNORE = 1;
	const ERROR_TRIGGER = 3;
	const ERROR_THROW = 5;
	
	/**
	 * String value
	 * @var string
	 */
	protected $value;
	
	/**
	 * The original string value
	 * @var string
	 */
	protected $original;
	
	/**
	 * Error mode. One of "ERROR_*" class constants
	 * @var int
	 */
	protected static $errorMode = self::ERROR_THROW;
	
	/**
	 * Constructor
	 * 
	 * @param string $string
	 */
	public function __construct($string) {
		$this->set($string);
	}
	
	/**
	 * @return $this
	 */
	public function trim($charlist = null) {
		$this->value = isset($charlist) ? trim($this->value, $charlist) : trim($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function ltrim($charlist = null) {
		$this->value = isset($charlist) ? ltrim($this->value, $charlist) : ltrim($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function rtrim($charlist = null) {
		$this->value = isset($charlist) ? rtrim($this->value, $charlist) : rtrim($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function sub($start, $length = null) {
		if (static::mb()) {
			$this->value = isset($length) 
				? mb_substr($this->value, $start, $length)
				: mb_substr($this->value, $start);
		} else {
			$this->value = isset($length) 
				? substr($this->value, $start, $length) 
				: substr($this->value, $start);
		}
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function str($needle, $before_needle = false) {
		$this->value = static::mb() 
			? mb_strstr($this->value, $needle, $before_needle)
			: strstr($this->value, $needle, $before_needle);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function replace($search, $replace, &$count = 0) {
		$this->value = str_replace($search, $replace, $this->value, $count);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function ireplace($search, $replace, &$count = 0) {
		$this->value = str_ireplace($search, $replace, $this->value, $count);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function pad($pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT) {
		$this->value = str_pad($this->value, $pad_length, $pad_string, $pad_type);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function shuffle() {
		$this->value = str_shuffle($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function bin2hex() {
		$this->value = bin2hex($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function hex2bin() {
		$this->value = hex2bin($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function hexdec() {
		$this->value = hexdec($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function sanitize($type = FILTER_SANITIZE_STRING, $options = 0) {
		$this->value = filter_var($this->value, $type, $options);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function htmlentities($flags = ENT_COMPAT, $charset = 'UTF-8', $double_encode = false) {
		$this->value = htmlentities($this->value, $flags, $charset, $double_encode);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function htmlspecialchars($flags = ENT_COMPAT, $charset = 'UTF-8', $double_encode = false) {
		$this->value = htmlspecialchars($this->value, $flags, $charset, $double_encode);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function htmlEntityDecode($flags = ENT_COMPAT, $charset = 'UTF-8') {
		$this->value = html_entity_decode($this->value, $flags, $charset);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function htmlSpecialCharsDecode($flags = ENT_COMPAT) {
		$this->value = htmlspecialchars_decode($this->value, $flags);
		return $this;
	}

	/**
	 * ------------------------------------------------
	 * Case
	 * ------------------------------------------------
	 */
	
	/**
	 * @return $this
	 */
	public function convertCase($mode) {
		if (static::mb()) {
			$this->value = mb_convert_case($this->value, $mode);
		} else {
			switch($mode) {
				case self::CASE_LOWER:
					$this->lower();
					break;
				case self::CASE_UPPER:
					$this->upper();
					break;
				case self::CASE_TITLE:
					$this->ucwords();
					break;
			}
		}
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function upper() {
		$this->value = Text::upper($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function lower() {
		$this->value = Text::lower($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function ucwords() {
		$this->value = ucwords($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function ucfirst() {
		$this->value = ucfirst($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function lcfirst() {
		$this->value = lcfirst($this->value);
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function title() {
		return $this->convertCase(self::CASE_TITLE);
	}
	
	/**
	 * ------------------------------------------------
	 * Hashing
	 * ------------------------------------------------
	 */
	
	/**
	 * Applies md5() hashing algorithm to the string
	 * 
	 * @param bool $raw_output [Optional]
	 * @return $this
	 */
	public function md5($raw_output = false) {
		$this->value = md5($this->value, $raw_output);
		return $this;
	}
	
	/**
	 * Applies sha1() hashing algorithm to the string
	 * 
	 * @param bool $raw_output [Optional]
	 * @return $this
	 */
	public function sha1($raw_output = false) {
		$this->value = sha1($this->value, $raw_output);
		return $this;
	}
	
	/**
	 * Applies a given hashing algorithm to the string
	 * 
	 * @param string $algo Hashing algorithm
	 * @param bool $raw_output [Optional]
	 * @return $this
	 */
	public function hash($algo, $raw_output = false) {
		$this->value = hash($algo, $this->value, $raw_output);
		return $this;
	}
	
	/**
	 * Applies a given HMAC hashing algorithm to the string
	 * 
	 * @param string $algo Hashing algorithm
	 * @param string $key HMAC key
	 * @param bool $raw_output [Optional]
	 * @return $this
	 */
	public function hashHmac($algo, $key, $raw_output = false) {
		$this->value = hash_hmac($algo, $this->value, $key, $raw_output);
		return $this;
	}
	
	/**
	 * ------------------------------------------------
	 * Alteration
	 * ------------------------------------------------
	 */
	 
	/**
	 * Sets a new string value
	 * 
	 * @param string $string
	 * @return $this
	 */
	public function set($string) {
		
		if (! is_scalar($string) && ! method_exists($string, '__toString')) {
			throw new \InvalidArgumentException("Expecting string, given: ".gettype($string));
		}
		
		$this->value = (string)$string;
		
		if (! isset($this->original)) {
			$this->original = $this->value;
		}
		
		return $this;
	}
	
	/**
	 * Restores the string to its original value
	 * 
	 * @return $this
	 */
	public function restore() {
		$this->value = $this->original;
		return $this;
	}
	
	/**
	 * Prepends a string to the string
	 * 
	 * @param string $string
	 * @return $this
	 */
	public function prepend($string) {
		$this->value = $string.$this->value;
		return $this;
	}
	
	/**
	 * Appends a string to the string
	 * 
	 * @param string $string
	 * @return $this
	 */
	public function append($string) {
		$this->value .= $string;
		return $this;
	}
	
	/**
	 * Wraps the string between the two given
	 * 
	 * @param string $before String to prepend
	 * @param string $after String to append
	 * @return $this
	 */
	public function wrap($before, $after) {
		$this->value = $before.$this->value.$after;
		return $this;
	}
	
	/**
	 * Converts the string to another encoding
	 * 
	 * @param string $to_encoding The type of encoding that the string is being converted to.
	 * @param mixed $from_encoding [Optional] An array, or a comma separated enumerated list. If $from_encoding is 
	 * boolean true, the detected encoding will be used. If not specified, the internal encoding is used.
	 * @return $this
	 */
	public function convertEncoding($to_encoding, $from_encoding = null) {
		
		if (static::mb()) {
			
			if (true === $from_encoding) {
				$from_encoding = mb_detect_encoding($this->value);
			}
		
			$this->value = mb_convert_encoding($this->value, $to_encoding, $from_encoding);
		
		} else if (static::iconv()) {
		
			if (! isset($from_encoding)) {
				return static::error("Must pass from_encoding to convert using iconv().");
			}
		
			$this->value = iconv($from_encoding, $to_encoding, $this->value);
		}
		
		return $this;
	}
	
	/**
	 * --------------------------------------------------------------------
	 * The following methods return a value
	 * --------------------------------------------------------------------
	 */
	
	/**
	 * strlen()
	 * 
	 * @return int
	 */
	public function len() {
		return static::mb() ? mb_strlen($this->value) : strlen($this->value);
	}
	
	/**
	 * strpos()
	 * 
	 * @return int
	 */
	public function pos($needle, $offset = 0) {
		return static::mb() ? mb_strpos($this->value, $needle, $offset) : strpos($this->value, $needle, $offset);
	}
	
	/**
	 * stripos()
	 * 
	 * @return int
	 */
	public function ipos($needle, $offset = 0) {
		return static::mb() ? mb_stripos($this->value, $needle, $offset) : stripos($this->value, $needle, $offset);
	}
	
	/**
	 * strrchr()
	 * 
	 * @return int
	 */
	public function rchr($needle) {
		return static::mb() ? mb_strrchr($this->value, $needle) : strrchr($this->value, $needle);
	}
	
	/**
	 * @return bool
	 */
	public function startsWith($string, $case_insensitive = false) {
		return Text::startsWith($this->value, $string, $case_insensitive);
	}
	
	/**
	 * @return bool
	 */
	public function endsWith($string, $case_insensitive = false) {
		return Text::endsWith($this->value, $string, $case_insensitive);
	}
	
	/**
	 * Returns the detected string encoding
	 * 
	 * @return string
	 */
	public function detectEncoding() {
		if (! static::mb()) {
			return static::error("Must have mbstring extension loaded to detect encoding");
		}
		return mb_detect_encoding($this->value);
	}
	
	/**
	 * Validates the string using filter_var()
	 * 
	 * @return mixed
	 */
	public function validate($type, $options = 0) {
		return filter_var($this->value, $type, $options);
	}
	
	/**
	 * Returns the current string value
	 * @return string
	 */
	public function get() {
		return $this->value;
	}
	
	/**
	 * Returns the original string value
	 * @return string
	 */
	public function getOriginal() {
		return $this->original;
	}
	
	/**
	 * Whether the value has been altered from the original value
	 * @return bool
	 */
	public function isAltered() {
		return $this->value !== $this->original;
	}
	
	/**
	 * Allows print() and echo() methods
	 */
	public function __call($func, array $args) {
		switch($func) {
			case 'print':
				print $this->value;
				break;
			case 'echo':
				echo $this->value;
				break;
		}
	}
	
	/**
	 * Magic access to 'length' and 'encoding'
	 */
	public function __get($var) {
		switch($var) {
			case 'length':
				return $this->len();
			case 'encoding':
				return $this->detectEncoding();
			case 'firstChar':
				return $this->value[0];
			case 'lastChar':
				return static::mb() ? mb_substr($this->value, -1) : substr($this->value, -1);
		}
	}
	
	/**
	 * @return string
	 */
	public function __toString() {
		return (string)$this->value;
	}
	
	/**
	 * ------------------------------------------------
	 * ctype_* methods 
	 * ------------------------------------------------
	 */
	 
	/**
	 * @return bool
	 */
	public function isAlnum() {
		return ctype_alnum($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isAlpha() {
		return ctype_alpha($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isUpper() {
		return ctype_upper($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isLower() {
		return ctype_lower($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isPrintable() {
		return ctype_print($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isControl() {
		return ctype_cntrl($this->value);
	}
	
	/**
	 * @return bool
	 */
	public function isDigit() {
		return ctype_digit($this->value);
	}
	
	/**
	 * --------------------------------------------------------------------
	 * Static methods
	 * --------------------------------------------------------------------
	 */
	
	/**
	 * Sets the error mode
	 * 
	 * @param int $mode One of "ERROR_*" class constants
	 * @throws \InvalidArgumentException if given an invalid error mode
	 */
	public static function setErrorMode($mode) {
		if (! in_array($mode, array(self::ERROR_IGNORE, self::ERROR_THROW, self::ERROR_TRIGGER), true)) {
			throw new \InvalidArgumentException("Invalid error mode: '{$mode}'.");
		}
		static::$errorMode = $mode;
	}
	
	/**
	 * Whether mbstring extension is loaded
	 * @return bool
	 */
	public static function mb() {
		static $mb;
		return isset($mb) ? $mb : $mb = extension_loaded('mbstring');
	}
	
	/**
	 * Whether iconv extension is loaded
	 * @return bool
	 */
	public static function iconv() {
		static $iconv;
		return isset($iconv) ? $iconv : $iconv = extension_loaded('iconv');
	}
	
	/**
	 * Triggers an error, throws an exception, or does nothing, based on the current error mode
	 * 
	 * @param string $message Error message
	 * @return null
	 */
	protected static function error($message = 'An error occurred') {
		switch(static::$errorMode) {
			case self::ERROR_THROW:
				throw new \Exception($message);
				break;
			case self::ERROR_TRIGGER:
				trigger_error($message, E_USER_WARNING);
				break;
			case self::ERROR_IGNORE:
			default:
				break;
		}
		return null;
	}
	
}
