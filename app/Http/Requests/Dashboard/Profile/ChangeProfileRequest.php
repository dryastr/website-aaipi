<?php

namespace App\Http\Requests\Dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
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
        $user = $this->user()->getMe();

        if ($user->role_id == 1) {
            return [
                'fullname' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email,'.$user->id],
                'fullname' => ['required', 'string', 'max:150'],
                'mobile' => ['nullable', 'string', 'max:17'],
                'avatar' => ['nullable', 'file'],
            ];
        } else {
            return [
                'nip' => ['required', 'string', 'max:255', 'unique:registrations,nip,'.$user->registration->id],
                'fullname' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email,'.$user->id],
                'fullname' => ['required', 'string', 'max:150'],
                'mobile' => ['required', 'string', 'max:17'],
                'nama_instansi' => ['required', 'string', 'max:255'],
                'jabatan' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:255'],
                'avatar' => ['nullable', 'file'],
            ];
        }

    }
}
