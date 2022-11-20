<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePlayerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255|required',
            'position' => 'string|max:255|required|in:defender,midfielder,forward',
            'playerSkills.*.skill' => 'string|max:255|required|in:defense,attack,speed,strength,stamina',
            'playerSkills.*.value' => 'integer|min:0|required',
        ];
    }

    public function messages()
    {
        return [
            '*' => 'Invalid value for :attribute: :input',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        $response = [
            'message' => $validator->errors()->first(),
        ];
        throw new HttpResponseException(response()->json($response, 400)); 
    }
}
