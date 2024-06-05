<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'fullname' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'status' => ['required', 'in:active,inactive'],
            // 'role_id' => ['required', 'integer', 'exists:roles,id'],
            'password' => ['required', 'string'],
        ];
    }
}
