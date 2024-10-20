<?php

namespace App\Http\Requests;

use App\Exceptions\GeneralJsonException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "name"=> "required",
            "email" => "required|email|unique:users,email",
            "password"=> "required",
        ];
    }

    /**
     * @param Validator $validator
     * @throws GeneralJsonException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new GeneralJsonException($validator->errors()->toJson(), decode: true);
    }
}
