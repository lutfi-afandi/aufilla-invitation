<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => Str::slug($this->username)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($userId),
                function ($attribute, $value, $fail) {
                    $reserved = ['admin', 'login', 'register', 'preview', 'receptionist', 'dashboard', 'api', 'welcome-screen', 'kado', 'tamu'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Username ini tidak bisa digunakan.');
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
}
