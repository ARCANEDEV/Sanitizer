<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use DateTime;
use InvalidArgumentException;

/**
 * Class     FormatDateFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormatDateFilter implements Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Format date of the given string.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return string|mixed
     */
    public function filter($value, array $options = [])
    {
        if ( ! is_string($value) || empty(trim($value))) {
            return $value;
        }

        $this->checkOptions($options);

        list($currentFormat, $targetFormat) = array_map('trim', $options);

        return DateTime::CreateFromFormat($currentFormat, $value)->format($targetFormat);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check Options.
     *
     * @param  array  $options
     *
     * @throws \InvalidArgumentException
     */
    private function checkOptions(array $options)
    {
        if (count($options) != 2) {
            throw new InvalidArgumentException(
                'The Sanitizer Format Date filter requires both the current date format as well as the target format.'
            );
        }
    }
}
