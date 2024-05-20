<?php

namespace App\Http\Requests;

use App\Rules\EmailUniqueRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', new EmailUniqueRule()],
            'password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'     => 'Email harus diisi',
            'password.required'     => 'Password harus diisi',
            'password.min'     => 'Password minimal 6 huruf',
            'password.regex'     => 'Password minimal terdapat huruf besar, kecil, angka dan simbol',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->error($validator->errors(), 400));
    }
}
