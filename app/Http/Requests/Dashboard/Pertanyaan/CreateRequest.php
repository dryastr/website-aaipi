<?php

namespace App\Http\Requests\Dashboard\Pertanyaan;

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
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            // 'title' => 'nullable|string',
            // 'deskripsi' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // 'title' => 'required|string',
            // 'description' => 'required|string',

        ];
    }
}
