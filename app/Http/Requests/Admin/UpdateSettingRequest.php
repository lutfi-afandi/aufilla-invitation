<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
        $group = $this->input('group', 'general');

        $rules = [
            'group' => ['required', 'string', 'in:general,contact,seo,faq'],
        ];

        if ($group === 'general') {
            $rules['app_name'] = ['nullable', 'string', 'max:100'];
            $rules['app_tagline'] = ['nullable', 'string', 'max:255'];
            $rules['app_logo'] = ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'];
            $rules['app_logo_dark'] = ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'];
            $rules['app_favicon'] = ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,svg', 'max:1024'];
        } elseif ($group === 'contact') {
            $rules['contact_whatsapp'] = ['nullable', 'string', 'max:30'];
            $rules['contact_email'] = ['nullable', 'email', 'max:100'];
            $rules['contact_instagram'] = ['nullable', 'string', 'max:100'];
            $rules['contact_address'] = ['nullable', 'string', 'max:255'];
        } elseif ($group === 'seo') {
            $rules['meta_title'] = ['nullable', 'string', 'max:255'];
            $rules['meta_description'] = ['nullable', 'string', 'max:500'];
            $rules['meta_keywords'] = ['nullable', 'string', 'max:500'];
            $rules['meta_author'] = ['nullable', 'string', 'max:100'];
            $rules['app_og_image'] = ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'];
        } elseif ($group === 'faq') {
            $rules['faqs'] = ['nullable', 'array'];
            $rules['faqs.*.pertanyaan'] = ['required_with:faqs', 'string', 'max:255'];
            $rules['faqs.*.jawaban'] = ['required_with:faqs', 'string', 'max:2000'];
        }

        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'group.required' => 'Grup pengaturan wajib disertakan.',
            'group.in' => 'Grup pengaturan tidak valid.',
            'app_logo.image' => 'File logo harus berupa format gambar valid.',
            'app_logo.max' => 'Ukuran file logo maksimal 2MB.',
            'app_favicon.max' => 'Ukuran file favicon maksimal 1MB.',
            'app_og_image.max' => 'Ukuran file OG Image maksimal 2MB.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'faqs.*.pertanyaan.required_with' => 'Setiap butir FAQ wajib memiliki pertanyaan.',
            'faqs.*.jawaban.required_with' => 'Setiap butir FAQ wajib memiliki jawaban.',
        ];
    }
}
