<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => Str::slug($this->username),
            'slug' => Str::slug($this->slug ?: $this->username),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clientId = $this->route('client') ?? $this->route('id');
        $client = User::find($clientId);
        $undangan = $client ? $client->undangans->first() : null;

        $reservedSlugs = [
            'admin', 'login', 'register', 'preview', 'receptionist', 'dashboard',
            'api', 'welcome-screen', 'kado', 'tamu', 'tema', 'paket', 'galeri',
            'ucapan', 'cerita', 'profile', 'storage', 'assets', 'logout',
        ];

        return [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('users', 'username')->ignore($clientId),
                function ($attribute, $value, $fail) use ($reservedSlugs) {
                    if (in_array(strtolower($value), $reservedSlugs)) {
                        $fail('Username ini merupakan kata kunci sistem dan tidak dapat digunakan.');
                    }
                },
            ],
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('undangans', 'slug')->ignore($undangan?->id),
                function ($attribute, $value, $fail) use ($reservedSlugs) {
                    if (in_array(strtolower($value), $reservedSlugs)) {
                        $fail('URL Slug undangan ini merupakan kata kunci sistem dan tidak dapat digunakan.');
                    }
                },
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:100',
                Rule::unique('users', 'email')->ignore($clientId),
            ],
            'password' => 'nullable|string|min:6|max:50',
            'status' => 'required|in:aktif,kedaluwarsa',
            'theme_id' => 'required|exists:temas,id',
            'package_id' => 'nullable|exists:pakets,id',
        ];
    }

    /**
     * Get custom Indonesian validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Username login wajib diisi.',
            'username.min' => 'Username minimal terdiri dari 3 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain. Silakan pilih username lain.',

            'slug.required' => 'URL Slug undangan wajib diisi.',
            'slug.min' => 'URL Slug minimal terdiri dari 3 karakter.',
            'slug.max' => 'URL Slug maksimal 100 karakter.',
            'slug.unique' => 'URL Slug ini sudah terdaftar pada undangan lain. Silakan buat slug unik.',

            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 100 karakter.',
            'email.unique' => 'Alamat email ini sudah terdaftar pada akun lain.',

            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.max' => 'Password maksimal 50 karakter.',

            'status.required' => 'Status undangan wajib dipilih.',
            'status.in' => 'Status undangan harus berupa "aktif" atau "kedaluwarsa".',

            'theme_id.required' => 'Tema undangan wajib dipilih dari katalog.',
            'theme_id.exists' => 'Tema undangan yang dipilih tidak valid atau tidak ditemukan.',

            'package_id.exists' => 'Paket undangan yang dipilih tidak valid atau tidak ditemukan.',
        ];
    }
}
