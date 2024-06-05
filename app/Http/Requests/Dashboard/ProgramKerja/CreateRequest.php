<?php

namespace App\Http\Requests\Dashboard\ProgramKerja;

use App\Models\ProgramKerja;
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

        // return [
        //     'title' => 'required',
        //     'description' => 'required',
        //     'title' => 'required',
        //     'description' => 'required',
        //     'image' => [
        //         'nullable',
        //         'image',
        //         'mimes:jpeg,png,jpg,gif',
        //         'max:2048',
        //     ],
        //     'status_image' => [
        //         'nullable',
        //         'boolean',
        //         function ($attribute, $value, $fail) {

        //             if ($value) {
        //                 ProgramKerja::where('status_image', true)->update(['status_image' => false]);
        //             }
        //         },
        //     ],
        //     'banner' => [
        //         'nullable',
        //         'image',
        //         'mimes:jpeg,png,jpg,gif',
        //         'max:2048',
        //     ],
        //     'status_banner' => [
        //         'nullable',
        //         'boolean',
        //         function ($attribute, $value, $fail) {
        //             if ($value) {
        //                 ProgramKerja::where('status_banner', true)->update(['status_banner' => false]);
        //             }
        //         },
        //     ],
        //     'icon' => 'nullable|string',
        // ];
        return [
            'title' => 'required',
            'description' => 'nullable', // Ubah menjadi nullable agar menjadi opsional
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
        ];
    }
}
