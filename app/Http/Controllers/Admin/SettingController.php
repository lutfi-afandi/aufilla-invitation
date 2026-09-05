<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings management view with all tabs.
     */
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $faqs = Setting::getJson('faqs', []);

        return view('admin.settings.index', compact('settings', 'faqs'));
    }

    /**
     * Update settings for a specific group via AJAX.
     */
    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $group = $request->input('group', 'general');
        $validated = $request->validated();

        if ($group === 'faq') {
            $faqs = $request->input('faqs', []);
            // Clean up and re-index array
            $cleanFaqs = [];
            if (is_array($faqs)) {
                foreach ($faqs as $item) {
                    if (!empty($item['pertanyaan']) && !empty($item['jawaban'])) {
                        $cleanFaqs[] = [
                            'pertanyaan' => trim($item['pertanyaan']),
                            'jawaban' => trim($item['jawaban']),
                        ];
                    }
                }
            }
            Setting::set('faqs', $cleanFaqs, 'faq');

            return response()->json([
                'success' => true,
                'message' => 'Daftar FAQ berhasil diperbarui.',
                'faqs' => $cleanFaqs,
            ]);
        }

        // Handle Image / File Uploads
        $fileFields = ['app_logo', 'app_logo_dark', 'app_favicon', 'app_og_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $oldFile = Setting::get($field);
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                if (in_array($field, ['app_logo', 'app_logo_dark', 'app_og_image'])) {
                    $path = ImageHelper::uploadAndCompress($request->file($field), 'settings');
                } else {
                    $path = $request->file($field)->store('settings', 'public');
                }

                Setting::set($field, $path, $group);
            }
        }

        // Handle other text inputs
        $excludedKeys = array_merge($fileFields, ['_token', '_method', 'group', 'faqs']);
        foreach ($validated as $key => $value) {
            if (!in_array($key, $excludedKeys, true)) {
                Setting::set($key, $value, $group);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan ' . ucfirst($group) . ' berhasil disimpan.',
        ]);
    }
}
