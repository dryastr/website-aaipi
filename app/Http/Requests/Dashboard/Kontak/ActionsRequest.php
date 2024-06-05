<?php

namespace App\Http\Requests\Dashboard\Kontak;

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
            'title' => ['required'],
            'content' => ['required'],
            'image' => ['required'],
            'alamat_kantor' => ['required'],
            'hubungi_kami' => ['required'],
            'email_kami' => ['required'],
            'jam_kerja' => ['required'],
        ];
    }
}