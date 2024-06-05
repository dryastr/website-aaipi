<?php

namespace App\Http\Requests\Dashboard\Banner;

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
            'beranda_kontak' => ['nullable'],
            'beranda_kursus' => ['nullable'],
            'sejarah_singkat' => ['nullable'],
            'visi_dan_misi' => ['nullable'],
            'struktur_organisasi' => ['nullable'],
            'program_kerja' => ['nullable'],
            'anggaran_dasar' => ['nullable'],
            'publikasi' => ['nullable'],
            'keanggotaan' => ['nullable'],
            'elms_aaipi' => ['nullable'],
            'telaah_sejawat' => ['nullable'],
            'kontak' => ['nullable'],
        ];
    }
}
