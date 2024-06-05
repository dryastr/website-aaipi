<?php

namespace App\Http\Requests\Dashboard\Kontak;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title_content' => 'nullable|string',
            'title_banner' => 'nullable|string',
            'title' => 'required|string',
            'kode' => 'nullable|string',
            'icon' => 'required|string',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
