<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LookupRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'      => 'required',
            'id'        => 'required_without:username|required_if:type,steam',
            'username'  => 'required_without:id'
        ];
    }

    public function messages()
    {
        return [
            'id.required_if' => 'Steam only supports IDs'
        ];
    }

    /**
     * Added custom failed validation response to ensure json is returned even through browser
     *
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ],422));
    }
}
