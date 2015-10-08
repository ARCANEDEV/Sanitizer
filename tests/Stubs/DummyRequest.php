<?php namespace Arcanedev\Sanitizer\Tests\Stubs;

use Arcanedev\Sanitizer\Http\FormRequest;

/**
 * Class     DummyRequest
 *
 * @package  Arcanedev\Sanitizer\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DummyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Sanitizer's rules to be applied to the input.
     *
     * @return array
     */
    protected function sanitizerRules()
    {
        return [
            'email' => 'email',
        ];
    }
}
