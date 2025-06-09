<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if the user is authorized, false otherwise.
     *
     * This method always returns true, meaning any authenticated user can make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array The array of validation rules for the country request.
     *
     * Rules:
     * - 'code': Required, must be a string of exactly 2 characters, and unique in the 'countries' table.
     * - 'name': Required, must be a string with a maximum length of 255 characters, and unique in the 'countries' table.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:2', 'unique:countries,code'],
            'name' => ['required', 'string', 'max:255', 'unique:countries,name'],
        ];
    }
}
