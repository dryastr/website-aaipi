<?php

namespace App\Http\Requests\Dashboard\VisiMisi;

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
            'title_banner' => 'required',
            'conten_tentang' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'banner' => $this->imageRules(),
            'image' => $this->imageRules(),
        ];
    }

    /**
     * Get the image validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    private function imageRules(): array
    {
        return [
            'nullable', // Make the field optional
            'image',
            'mimes:jpeg,png,jpg,gif',
            'max:2048', // Adjust to the desired file size limit in kilobytes
        ];
    }
}
