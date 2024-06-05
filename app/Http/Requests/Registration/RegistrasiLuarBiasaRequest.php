<?php

namespace App\Http\Requests\Registration;

use App\Models\SyaratPendaftaran;
use Illuminate\Foundation\Http\FormRequest;

class RegistrasiLuarBiasaRequest extends FormRequest
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
        $persyaratan = new SyaratPendaftaran();
        $persyaratanFile = $persyaratan->getTypeFile();
        $rule = [];

        $rule = [
            'fullname' => ['required'],
            'email' => ['required','email','unique:users,email,inactive,status', 'regex:/^.+@.+\.[a-zA-Z]{2,}$/'],
            'mobile' => ['required', 'unique:users,mobile,inactive,status'],
            'password' => ['required', 'string', 'min:8', 'max:15', 'regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password' => ['required', 'string', 'min:8', 'max:15'],
            'agreement' => ['accepted'],
        ];

        foreach ($persyaratanFile as $item) {
            // $rule['syarat_pendaftaran_'.$item['id']] = 'required|file|max:2048';
            $rule['syarat_pendaftaran_'.$item['id']] = $item['validation_file'];
        }

        return $rule;
    }

    public function messages()
    {
        $messages = [
            'fullname.required' => 'Nama wajib diisi',
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Masukan alamat email yang benar.',
            'email.unique' => 'Alamat email sudah terdaftar',
            'mobile.required' => 'Nomor telepon wajib diisi',
            'mobile.unique' => 'Nomor telepon sudah terdaftar',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.regex' => 'Kata sandi harus memiliki huruf, angka, dan special karakter',
            'password.same' => 'Kata sandi dan konfirmasi kata sandi tidak cocok',
            'confirm_password.required' => 'Konfirmasi kata sandi wajib diisi',
            'confirm_password.same' => 'Kata sandi dan konfirmasi kata sandi tidak cocok',
            'confirm_password.min' => 'Konfirmasi kata sandi minimal 8 karakter',
            'agreement.accepted' => 'Anda harus menyetujui persyaratan pendaftaran',
        ];

        $persyaratan = new SyaratPendaftaran();
        $persyaratanFile = $persyaratan->getTypeFile();
        
        foreach ($persyaratanFile as $item) {
            $messages['syarat_pendaftaran_' . $item['id'] . '.required'] = 'File wajib diisi';
            $messages['syarat_pendaftaran_' . $item['id'] . '.mimes'] = 'File harus bertipe: :values';
            $messages['syarat_pendaftaran_' . $item['id'] . '.max'] = 'Maksimal size file 2MB';
        }

        return $messages;
    }
}
