<?php

namespace App\Http\Requests;

use App\Defines\Reader;
use Illuminate\Foundation\Http\FormRequest;

class ReaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return Reader::rules();
    }

    public function messages(): array
    {
        return Reader::message();
    }

}
