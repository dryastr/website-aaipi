<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'new_password' => ['required', 'string', 'required_with:new_password_confirmation', 'same:new_password_confirmation'],
            'new_password_confirmation' => ['required', 'string'],
        ];
    }

    
}
