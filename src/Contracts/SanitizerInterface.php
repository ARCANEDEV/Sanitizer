<?php namespace Arcanedev\Sanitizer\Contracts;

use Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException;
use Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFound;
use Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException;
use Arcanedev\Sanitizer\Exceptions\SanitizerNotCallableException;

interface SanitizerInterface
{
	/* ------------------------------------------------------------------------------------------------
	 |  Getters & Setters
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * Get sanitizer rules
	 *
	 * @return array
	 */
	public function getRules();

	/**
	 * Set sanitizer rules
	 *
	 * @param array $rules
	 *
	 * @throws InvalidSanitizersException
	 *
	 * @return SanitizerInterface
	 */
	public function setRules($rules);

	/**
	 * @return array
	 */
	public function getSanitizers();

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
	public function sanitize(array $data, $rules = null);

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
	 * @return SanitizerInterface
	 */
	public function register($name, $callback, $override = false);

	/* ------------------------------------------------------------------------------------------------
	 |  Check Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * Check has sanitizer rules
	 *
	 * @return bool
	 */
	public function hasRules();

	/**
	 * Check has custom sanitizers
	 *
	 * @return bool
	 */
	public function hasSanitizers();
}
