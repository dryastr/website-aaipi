<?php

namespace App\Http\Requests\Dashboard\Sponsor;

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
            'title' => 'required',
            'link' => 'required',
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
            'expired_at' => 'required'
        ];
    }
}
