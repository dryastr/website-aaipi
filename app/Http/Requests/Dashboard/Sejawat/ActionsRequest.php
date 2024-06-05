<?php

namespace App\Http\Requests\Dashboard\Sejawat;

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
            'link_title' => ['required'],
            'link' => ['required'],
        ];
    }
}
