<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('username')) {
            $this->merge([
                'username' => Str::slug($this->username)
            ]);
        }
    }

    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->route('user');

        return [
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($userId),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini reservasi sistem dan tidak bisa digunakan.');
                    }
                    if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $value)) {
                        $fail('Username hanya boleh berisi huruf, angka, strip (-), garis bawah (_), atau titik (.).');
                    }
                }
            ],
            'email'    => ['nullable', 'email', 'max:100', Rule::unique('users')->ignore($userId)],
            'password' => 'nullable|string|min:6|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Username admin wajib diisi.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan username lain.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email ini sudah terdaftar untuk akun pengguna lain.',
            'password.min' => 'Password baru minimal terdiri dari 6 karakter.',
            'password.max' => 'Password baru maksimal 50 karakter.',
        ];
    }
}
