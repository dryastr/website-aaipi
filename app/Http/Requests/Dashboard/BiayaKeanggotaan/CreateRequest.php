<?php

namespace App\Http\Requests\Dashboard\BiayaKeanggotaan;

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
            'biaya' => 'required|numeric',
            'tahun' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'jenis_keanggotaan' => 'nullable|in:anggota-biasa,anggota-luar-biasa,anggota-kehormatan',
        ];
    }
}
