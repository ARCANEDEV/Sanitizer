<?php namespace Arcanedev\Sanitizer\Http;

use Arcanedev\Support\Bases\FormRequest as BaseFormRequest;

/**
 * Class     FormRequest
 *
 * @package  Arcanedev\Sanitizer\Http
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize input before validating.
     */
    public function validate()
    {
        $this->sanitize();

        parent::validate();
    }

    /**
     * Sanitize this request's input.
     */
    protected function sanitize()
    {
        $sanitized = sanitizer()->make(
            $this->all(),
            $this->sanitizerRules()
        );

        $this->replace($sanitized);
    }

    /**
     * Sanitizer's rules to be applied to the input.
     *
     * @return array
     */
    abstract protected function sanitizerRules();
}
