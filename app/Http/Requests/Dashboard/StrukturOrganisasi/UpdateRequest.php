<?php

namespace App\Http\Requests\Dashboard\StrukturOrganisasi;

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
            'jabatan' => 'nullable|in:ketua,manajemen-eksekutif,komite-kode-etik,komite-standar-audit,komite-telaah-sejawat',
            'jabatan_title' => 'required',
            'desc_jabatan' => 'required',
            // 'title_pdf',
            // 'pdf' => 'nullable|mimes:pdf|max:2048',

        ];
    }

    /**
     * Get the image validation rules.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
}
