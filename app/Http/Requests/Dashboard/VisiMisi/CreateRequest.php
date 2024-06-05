<?php

namespace App\Http\Requests\Dashboard\VisiMisi;

use App\Models\VisiMisi;
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
            'title_banner' => 'required',
            'conten_tentang' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'banner' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    // Cek apakah ada record dengan image yang sudah diisi
                    $existingRecord = VisiMisi::whereNotNull('banner')->first();

                    // Jika ada, berikan pesan error
                    if ($existingRecord) {
                        $fail("The $attribute has already been taken.");
                    }
                },
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) {
                    // Cek apakah ada record dengan image yang sudah diisi
                    $existingRecord = VisiMisi::whereNotNull('image')->first();

                    // Jika ada, berikan pesan error
                    if ($existingRecord) {
                        $fail("The $attribute has already been taken.");
                    }
                },
            ],
        ];
    }
}
