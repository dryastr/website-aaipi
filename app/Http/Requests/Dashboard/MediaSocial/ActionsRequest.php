<?php

namespace App\Http\Requests\Dashboard\MediaSocial;

use Illuminate\Foundation\Http\FormRequest;

class ActionsRequest extends FormRequest
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
            // 'title' => ['nullable', 'string'],
            // 'content' => ['nullable', 'string'],
            'facebook' => ['required'],
            'twitter' => ['required'],
            'instagram' => ['required'],
            'youtube' => ['required'],
            'linkedin' => ['required'],
        ];
    }
}
