<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\SanitizerInterface;

use Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException;
use Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFoundException;
use Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException;
use Arcanedev\Sanitizer\Exceptions\NotCallableException;

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
    private $sanitizers = [];

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set sanitizer rules
     *
     * @param  array|null $rules
     *
     * @throws InvalidSanitizersException
     *
     * @return Sanitizer
     */
    public function setRules($rules)
    {
        if (! is_null($rules) and ! empty($rules)) {
            $this->checkRules($rules);

            $this->rules = array_merge($this->rules, $rules);
        }

        return $this;
    }

    /**
     * Get sanitizer method name
     *
     * @param string $name
     *
     * @return string
     */
    private function getSanitizerMethodName($name)
    {
        return 'sanitize' . ucwords($name);
    }

    /**
     * Get sanitizer method
     *
     * @param string $sanitizer
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
    public function sanitize(array $data, $rules = null)
    {
        $this->setRules($rules);

        // Sanitize each fields by rules
        foreach ($this->rules as $field => $sanitizerRules) {
            if (! isset($data[$field])) {
                continue;
            }

            $this->applySanitizers($data[$field], $sanitizerRules);
        }

        return $data;
    }

    /**
     * Apply Sanitizers
     *
     * @param mixed $value
     * @param array $sanitizers
     *
     * @throws InvalidSanitizersException
     * @throws SanitizeMethodNotFoundException
     *
     * @return mixed
     */
    private function applySanitizers(&$value, $sanitizers)
    {
        foreach ($this->splitSanitizers($sanitizers) as $sanitizer) {
            $value = $this->applySanitizer($value, $sanitizer);
        }

        return $value;
    }

    /**
     * Convert sanitizer rules to array
     *
     * @param string|array $sanitizers
     *
     * @throws InvalidSanitizersException
     *
     * @return array
     */
    private function splitSanitizers($sanitizers)
    {
        if (is_array($sanitizers)) {
            return $sanitizers;
        }

        if (is_string($sanitizers)) {
            return $this->splitStringSanitizers($sanitizers);
        }

        throw new InvalidSanitizersException(
            'Sanitizer rules must be an array or string.'
        );
    }

    /**
     * @param $sanitizers
     *
     * @throws InvalidSanitizersException
     *
     * @return array
     */
    private function splitStringSanitizers($sanitizers)
    {
        if (empty($sanitizers)) {
            throw new InvalidSanitizersException(
                'Sanitizer rules must not be an empty string.'
            );
        }

        $sanitizers = explode('|', $sanitizers);

        $sanitizers = array_map(function($sanitizer) {
            return trim($sanitizer);
        }, $sanitizers);

        return array_filter($sanitizers);
    }


    /**
     * Apply Sanitizer
     *
     * @param mixed $value
     * @param string $sanitizer
     *
     * @throws SanitizeMethodNotFoundException
     *
     * @return mixed
     */
    private function applySanitizer($value, $sanitizer)
    {
        if (! $this->sanitizerExists($sanitizer)) {
            throw new SanitizeMethodNotFoundException(
                "Sanitize Method [$sanitizer] not found !"
            );
        }

        // If a custom sanitizer is registered on the subclass, then let's trigger that instead.
        if ($this->hasSanitizerMethod($sanitizer)) {
            $sanitizer = $this->getSanitizerMethod($sanitizer);
        }
        elseif ($this->hasCustomSanitizer($sanitizer)) {
            $sanitizer = $this->sanitizers[$sanitizer];
        }

        return call_user_func($sanitizer, $value);
    }

    /**
     * Register a custom sanitizer
     *
     * @param string   $name     Name of the sanitizer
     * @param Callable $callback
     * @param bool     $override Override sanitizer if it already exists
     *
     * @throws NotCallableException
     * @throws SanitizerMethodAlreadyExistsException
     *
     * @return Sanitizer
     */
    public function register($name, $callback, $override = false)
    {
        if (! is_callable($callback)) {
            throw new NotCallableException(
                'The $callback argument of register() must be callable.'
            );
        }

        if ($this->hasCustomSanitizer($name) and $override === false) {
            throw new SanitizerMethodAlreadyExistsException(
                'Sanitizer with this name already exists.'
            );
        }

        $this->sanitizers[$name] = $callback;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Function
     | ------------------------------------------------------------------------------------------------
     */
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
     * Check if has a custom sanitizer method
     *
     * @param string $name
     *
     * @return bool
     */
    private function hasSanitizerMethod($name)
    {
        return method_exists($this, $this->getSanitizerMethodName($name));
    }

    /**
     * Check if has a custom sanitizer closure
     *
     * @param string $name
     *
     * @return bool
     */
    private function hasCustomSanitizer($name)
    {
        return array_key_exists($name, $this->sanitizers);
    }

    /**
     * Check Rules
     *
     * @param array $rules
     *
     * @throws InvalidSanitizersException
     */
    private function checkRules($rules)
    {
        if (! is_array($rules)) {
            throw new InvalidSanitizersException(
                'The sanitizer rules must be an array, ' . gettype($rules) . ' is given'
            );
        }
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
        $email = strtolower(trim($email));

        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize an url.
     *
     * @param string $url
     *
     * @return string
     */
    protected function sanitizeUrl($url)
    {
        $url = trim($url);

        // $url = parse_url($url);
        if (substr($url, 0, 7) !== 'http://' or substr($url, 0, 8) !== 'https://') {
            $url = "http://" . $url;
        }

        return filter_var($url, FILTER_SANITIZE_URL);
    }
}
