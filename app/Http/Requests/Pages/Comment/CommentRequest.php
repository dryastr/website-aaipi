<?php

namespace App\Http\Requests\Pages\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'news_id' => ['required'],
            'parent_id' => ['nullable'],
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'komentar' => ['required', 'max:500'],
        ];
    }
}
