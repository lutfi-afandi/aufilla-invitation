<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriTemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('theme_category') ?? $this->route('id');

        $rules = [
            'nama' => 'required|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];

        if ($this->isMethod('POST')) {
            $rules['slug'] = 'nullable|string|max:100|unique:kategori_temas,slug';
        } else {
            $rules['slug'] = [
                'nullable',
                'string',
                'max:100',
                Rule::unique('kategori_temas', 'slug')->ignore($categoryId),
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori tema wajib diisi.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'slug.unique' => 'Slug kategori sudah digunakan.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan tidak boleh kurang dari 0.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->has('nama') && !$this->filled('slug')) {
            $merge['slug'] = Str::slug($this->input('nama'), '_');
        } elseif ($this->filled('slug')) {
            $merge['slug'] = Str::slug($this->input('slug'), '_');
        }

        if ($this->has('is_active')) {
            $merge['is_active'] = filter_var($this->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        if ($this->has('urutan')) {
            $merge['urutan'] = (int) $this->input('urutan', 0);
        }

        if (!empty($merge)) {
            $this->merge($merge);
        }
    }
}
