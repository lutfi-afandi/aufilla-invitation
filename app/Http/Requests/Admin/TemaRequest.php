<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $themeId = $this->route('theme') ?? $this->route('id');

        $rules = [
            'name' => 'required|string|max:100',
            'category' => 'required|string|exists:kategori_temas,slug',
            'tingkatan' => 'required|in:standar,premium,eksklusif',
            'harga_tambahan' => 'nullable|numeric|min:0',
            'is_privat' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        if ($this->isMethod('POST')) {
            $rules['code'] = 'required|string|max:50|unique:temas,code';
        } else {
            $rules['code'] = [
                'nullable',
                'string',
                'max:50',
                Rule::unique('temas', 'code')->ignore($themeId),
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tema wajib diisi.',
            'name.max' => 'Nama tema maksimal 100 karakter.',
            'category.required' => 'Kategori tema wajib dipilih.',
            'category.in' => 'Kategori tema tidak valid.',
            'tingkatan.required' => 'Tingkatan tema wajib dipilih.',
            'tingkatan.in' => 'Tingkatan tema tidak valid.',
            'harga_tambahan.numeric' => 'Harga tambahan harus berupa angka.',
            'harga_tambahan.min' => 'Harga tambahan tidak boleh negatif.',
            'code.required' => 'Kode tema wajib diisi.',
            'code.max' => 'Kode tema maksimal 50 karakter.',
            'code.unique' => 'Kode tema sudah digunakan oleh tema lain.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB (2048 KB).',
        ];
    }

    protected function prepareForValidation()
    {
        $merge = [];
        if ($this->has('is_active')) {
            $merge['is_active'] = filter_var($this->input('is_active'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }
        if ($this->has('is_privat')) {
            $merge['is_privat'] = filter_var($this->input('is_privat'), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }
        if ($this->has('harga_tambahan')) {
            $merge['harga_tambahan'] = (float) $this->input('harga_tambahan', 0);
        }
        if (!empty($merge)) {
            $this->merge($merge);
        }
    }
}
