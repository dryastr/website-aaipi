<?php

namespace App\Http\Requests\Dashboard\SyaratPendaftaran;

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
            'title' => ['required'],
            'type' => ['required', 'in:text,file,checklist'],
            'label' => ['exclude_if:type,text', 'required'],
            'diwajibkan' => ['exclude_if:type,text,checklist', 'required'],
            'type_file' => ['exclude_if:type,text,checklist', 'required'],
            'max_file.size' => ['exclude_if:type,text,checklist', 'required', 'integer'],
            'max_file.type' => ['exclude_if:type,text,checklist', 'required'],

        ];
    }

    public function messages()
    {
        return [
            'max_file.size.required' => 'Maximal size required',
            'max_file.size.integer' => 'Maximal size field must be an integer',
        ];
    }
}
