<?php namespace Arcanedev\Sanitizer\Contracts;

use Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException;
use Arcanedev\Sanitizer\Exceptions\NotCallableException;
use Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFoundException;
use Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException;

/**
 * Interface SanitizerInterface
 * @package Arcanedev\Sanitizer\Contracts
 */
interface SanitizerInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set sanitizer rules
     *
     * @param  array $rules
     *
     * @throws InvalidSanitizersException
     *
     * @return SanitizerInterface
     */
    public function setRules($rules);

    /* ------------------------------------------------------------------------------------------------
     |  Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize data
     *
     * @param  array      $data
     * @param  array|null $rules
     *
     * @throws InvalidSanitizersException
     * @throws SanitizeMethodNotFoundException
     *
     * @return array
     */
    public function sanitize(array $data, $rules = null);

    /**
     * Register a custom sanitizer
     *
     * @param  string   $name     Name of the sanitizer
     * @param  callable $callback
     * @param  bool     $override Override sanitizer if it already exists
     *
     * @throws NotCallableException
     * @throws SanitizerMethodAlreadyExistsException
     *
     * @return SanitizerInterface
     */
    public function register($name, $callback, $override = false);
}
