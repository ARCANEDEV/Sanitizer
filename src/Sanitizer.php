<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\SanitizerInterface;

use Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException;
use Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFound;
use Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException;
use Arcanedev\Sanitizer\Exceptions\SanitizerNotCallableException;

abstract class Sanitizer implements SanitizerInterface
{
	/* ------------------------------------------------------------------------------------------------
	 |  Properties
	 | ------------------------------------------------------------------------------------------------
	 */

	/**
	 * Sanitizer rules
	 *
	 * @var array
	 */
	protected $rules = [];

	/**
	 * Custom Sanitizers
	 *
	 * @var array
	 */
	protected $sanitizers = [];

	/* ------------------------------------------------------------------------------------------------
	 |  Getters & Setters
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * Get sanitizer rules
	 *
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}

	/**
	 * Set sanitizer rules
	 *
	 * @param array $rules
	 *
	 * @throws InvalidSanitizersException
	 *
	 * @return Sanitizer
	 */
	public function setRules($rules)
	{
		if ( ! is_array($rules) ) {
			throw new InvalidSanitizersException('The sanitizer rules must be an array, ' . gettype($rules) . ' is given');
		}

		$this->rules = array_merge($this->rules, $rules);

		return $this;
	}

	/**
	 * @return array
	 */
	public function getSanitizers()
	{
		return $this->sanitizers;
	}

	/**
	 * @param $name
	 *
	 * @return string
	 */
	private function getSanitizerMethodName($name)
	{
		return 'sanitize' . ucwords($name);
	}

	/**
	 * @param $sanitizer
	 *
	 * @return array
	 */
	private function getSanitizerMethod($sanitizer)
	{
		return [$this, $this->getSanitizerMethodName($sanitizer)];
	}

	/* ------------------------------------------------------------------------------------------------
	 |  Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * @param array      $data
	 * @param array|null $rules
	 *
	 * @throws InvalidSanitizersException
	 * @throws SanitizeMethodNotFound
	 *
	 * @return array
	 */
	public function sanitize(array $data, $rules = null)
	{
		if ( ! is_null($rules) and ! empty($rules) ) {
			$this->setRules($rules);
		}

		foreach ($this->rules as $field => $sanitizerRules)
		{
			if ( ! isset($data[$field]) ) {
				continue;
			}

			$data[$field] = $this->applySanitizers($data[$field], $sanitizerRules);
		}

		return $data;
	}

	/**
	 * Register a custom sanitizer
	 *
	 * @param string   $name     Name of the sanitizer
	 * @param callable $callback
	 * @param bool     $override Override sanitizer if it already exists
	 *
	 * @throws SanitizerNotCallableException
	 * @throws SanitizerMethodAlreadyExistsException
	 *
	 * @return Sanitizer
	 */
	public function register($name, $callback, $override = false)
	{
		if ( ! is_callable($callback) ) {
			throw new SanitizerNotCallableException('The $callback argument of register() must be callable.');
		}

		if ( $this->hasCustomSanitizer($name) and $override === false ) {
			throw new SanitizerMethodAlreadyExistsException('Sanitizer with this name already exists.');
		}

		$this->sanitizers[$name] = $callback;

		return $this;
	}

	/**
	 * @param mixed $value
	 * @param array $sanitizers
	 *
	 * @throws Exceptions\SanitizeMethodNotFound
	 *
	 * @return mixed
	 */
	private function applySanitizers($value, $sanitizers)
	{
		foreach ($this->splitSanitizers($sanitizers) as $sanitizer) {
			$value = $this->applySanitizer($value, $sanitizer);
		}

		return $value;
	}

	/**
	 * @param mixed $value
	 * @param string $sanitizer
	 *
	 * @throws SanitizeMethodNotFound
	 *
	 * @return mixed
	 */
	private function applySanitizer($value, $sanitizer)
	{
		// If a custom sanitizer is registered on the subclass, then let's trigger that instead.
		if ( ! $this->sanitizerExists($sanitizer) )
			throw new SanitizeMethodNotFound("Sanitize Method [" . $sanitizer . "] not found !");

		if ( $this->hasSanitizerMethod($sanitizer) ) {
			return call_user_func($this->getSanitizerMethod($sanitizer), $value);
		}

		if ( $this->hasCustomSanitizer($sanitizer) ) {
			$sanitizer = $this->sanitizers[$sanitizer];
		}

		return call_user_func($sanitizer, $value);
	}

	/**
	 * @param string|array $sanitizers
	 *
	 * @return array
	 */
	private function splitSanitizers($sanitizers)
	{
		return is_array($sanitizers) ? $sanitizers : explode('|', $sanitizers);
	}

	/* ------------------------------------------------------------------------------------------------
	 |  Check Function
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * Check has sanitizer rules
	 *
	 * @return bool
	 */
	public function hasRules()
	{
		return count($this->getRules()) > 0;
	}

	/**
	 * Check has custom sanitizers
	 *
	 * @return bool
	 */
	public function hasSanitizers()
	{
		return count($this->getSanitizers()) > 0;
	}

	/**
	 * Check if a sanitizer exists
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	private function sanitizerExists($name)
	{
		return $this->hasSanitizerMethod($name)
			or $this->hasCustomSanitizer($name)
			or function_exists($name);
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	private function hasSanitizerMethod($name)
	{
		return method_exists($this, $this->getSanitizerMethodName($name));
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	private function hasCustomSanitizer($name)
	{
		return array_key_exists($name, $this->getSanitizers());
	}

	/* ------------------------------------------------------------------------------------------------
	 |  Common Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * Sanitize an email address.
	 *
	 * @param  string $email
	 *
	 * @return string
	 */
	protected function sanitizeEmail($email)
	{
		return strtolower(trim($email));
	}

	protected function sanitizeUrl($url)
	{
		$url = strtolower(trim($url));

		// $url = parse_url($url);
		if ( substr($url, 0, 7) !== "http://" || substr($url, 0, 8) == "https://")
			$url = "http://" . $url;

		return $url;
	}
}
