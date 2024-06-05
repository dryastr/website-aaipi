<?php

namespace App\Http\Requests\Dashboard\AboutHistory;

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
            // 'title_content' => [
            //     'nullable',
            //     'string',
            //     function ($attribute, $value, $fail) {
            //         // Cek apakah ada record dengan title_content yang sudah diisi
            //         $existingRecord = Kontak::whereNotNull('title_content')->first();

            //         // Jika ada, berikan pesan error
            //         if ($existingRecord) {
            //             $fail("Anda Sudah Menambahkan Title Konten. Silahkan Kosongkan saja unutk title konten nya.");
            //         }
            //     },
            // ],
            // 'content' => [
            //     'nullable',
            //     'string',
            //     function ($attribute, $value, $fail) {
            //         // Cek apakah ada record dengan title_content yang sudah diisi
            //         $existingRecord = Kontak::whereNotNull('content')->first();

            //         // Jika ada, berikan pesan error
            //         if ($existingRecord) {
            //             $fail("Anda Sudah Menambahkan Konten. Silahkan Kosongkan saja unutk title konten nya.");
            //         }
            //     },
            // ],
            'title' => 'nullable|string',
            'title_banner' => 'nullable|string',
            'description' => 'nullable|string',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'image' => [
            //     'nullable',
            //     'image',
            //     'mimes:jpeg,png,jpg,gif',
            //     'max:2048',
            //     function ($attribute, $value, $fail) {
            //         // Cek apakah ada record dengan image yang sudah diisi
            //         $existingRecord = Kontak::whereNotNull('image')->first();

            //         // Jika ada, berikan pesan error
            //         if ($existingRecord) {
            //             $fail("The $attribute has already been taken.");
            //         }
            //     },
            // ],

        ];
    }
}
