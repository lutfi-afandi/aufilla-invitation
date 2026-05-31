<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    public function index(Request $request)
    {
        $query = Theme::withCount('invitations');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        // Urutkan berdasarkan yang terbaru, dan gunakan pagination
        $themes = $query->latest()->paginate(9)->withQueryString();

        if ($request->ajax()) {
            return view('admin.themes.partials.grid', compact('themes'))->render();
        }

        return view('admin.themes.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:themes,code',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'is_active' => $validated['is_active'] ?? true,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('themes/thumbnails', 'public');
        }

        Theme::create($data);

        return response()->json(['message' => 'Tema berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'is_active' => 'required|boolean',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $theme->name = $validated['name'];
        $theme->is_active = $validated['is_active'];

        if ($request->hasFile('thumbnail')) {
            if ($theme->thumbnail) {
                Storage::disk('public')->delete($theme->thumbnail);
            }
            $theme->thumbnail = $request->file('thumbnail')->store('themes/thumbnails', 'public');
        }

        $theme->save();

        return response()->json(['message' => 'Tema berhasil diperbarui.']);
    }

    public function toggleActive($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->is_active = ! $theme->is_active;
        $theme->save();

        return response()->json([
            'message' => 'Status tema berhasil diubah.',
            'is_active' => $theme->is_active,
        ]);
    }

    public function destroy($id)
    {
        $theme = Theme::withCount('invitations')->findOrFail($id);

        if ($theme->invitations_count > 0) {
            return response()->json([
                'message' => 'Gagal menghapus! Tema ini sedang digunakan oleh '.$theme->invitations_count.' klien.',
            ], 422);
        }

        if ($theme->thumbnail) {
            Storage::disk('public')->delete($theme->thumbnail);
        }

        $theme->delete();

        return response()->json(['message' => 'Tema berhasil dihapus.']);
    }
}
