<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaketRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Admin middleware already handles authorization
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'active_days' => 'required|integer|min:1|max:3650',
            'max_wa_send' => 'required|integer|min:1',
            'max_gallery_photos' => 'required|integer|min:0',
            'has_love_story' => 'nullable|boolean',
            'can_custom_music' => 'nullable|boolean',
            'is_priority_support' => 'nullable|boolean',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama paket harus diisi.',
            'name.max' => 'Nama paket maksimal 50 karakter.',
            'price.required' => 'Harga paket harus diisi.',
            'price.numeric' => 'Harga paket harus berupa angka.',
            'price.min' => 'Harga paket minimal 0.',
            'active_days.required' => 'Masa aktif harus diisi.',
            'active_days.integer' => 'Masa aktif harus berupa angka bulat.',
            'active_days.min' => 'Masa aktif minimal 1 hari.',
            'active_days.max' => 'Masa aktif paket maksimal 3650 hari (10 tahun).',
            'max_wa_send.required' => 'Maksimal kirim WA harus diisi.',
            'max_wa_send.integer' => 'Maksimal kirim WA harus berupa angka bulat.',
            'max_wa_send.min' => 'Maksimal kirim WA minimal 1.',
            'max_gallery_photos.required' => 'Maksimal foto galeri harus diisi.',
            'max_gallery_photos.integer' => 'Maksimal foto galeri harus berupa angka bulat.',
            'max_gallery_photos.min' => 'Maksimal foto galeri tidak boleh kurang dari 0.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'has_love_story' => $this->has('has_love_story') ? 1 : 0,
            'can_custom_music' => $this->has('can_custom_music') ? 1 : 0,
            'is_priority_support' => $this->has('is_priority_support') ? 1 : 0,
        ]);
    }
}
