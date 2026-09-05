<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TemaRequest;
use App\Models\KategoriTema;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemaController extends Controller
{
    public function index(Request $request)
    {
        $query = Tema::withCount('undangans')->with('kategoriTema');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($tingkatan = $request->input('tingkatan')) {
            $query->where('tingkatan', $tingkatan);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === '1');
        }

        $themes = $query->orderBy('id', 'desc')->paginate(12)->withQueryString();
        $categories = KategoriTema::where('is_active', true)->orderBy('urutan', 'asc')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.themes.partials.table', compact('themes', 'categories'))->render(),
            ]);
        }

        return view('admin.themes.index', compact('themes', 'categories'));
    }

    public function store(TemaRequest $request)
    {
        $validated = $request->validated();
        $kategoriId = KategoriTema::where('slug', $validated['category'])->value('id');

        $data = [
            'name' => $validated['name'],
            'code' => $validated['code'],
            'category' => $validated['category'],
            'kategori_tema_id' => $kategoriId,
            'tingkatan' => $validated['tingkatan'],
            'harga_tambahan' => $validated['harga_tambahan'] ?? 0,
            'is_privat' => $validated['is_privat'] ?? 0,
            'is_active' => isset($validated['is_active']) ? $validated['is_active'] : 1,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = ImageHelper::uploadAndCompress($request->file('thumbnail'), 'themes/thumbnails');
        }

        Tema::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Tema berhasil ditambahkan.',
        ]);
    }

    public function update(TemaRequest $request, $id)
    {
        $theme = Tema::findOrFail($id);
        $validated = $request->validated();

        $theme->name = $validated['name'];
        if (isset($validated['category'])) {
            $theme->category = $validated['category'];
            $theme->kategori_tema_id = KategoriTema::where('slug', $validated['category'])->value('id');
        }
        if (isset($validated['tingkatan'])) {
            $theme->tingkatan = $validated['tingkatan'];
        }
        if (array_key_exists('harga_tambahan', $validated)) {
            $theme->harga_tambahan = $validated['harga_tambahan'];
        }
        if (array_key_exists('is_privat', $validated)) {
            $theme->is_privat = $validated['is_privat'];
        }
        if (array_key_exists('is_active', $validated)) {
            $theme->is_active = $validated['is_active'];
        }

        if ($request->hasFile('thumbnail')) {
            if ($theme->thumbnail) {
                Storage::disk('public')->delete($theme->thumbnail);
            }
            $theme->thumbnail = ImageHelper::uploadAndCompress($request->file('thumbnail'), 'themes/thumbnails');
        }

        $theme->save();

        return response()->json([
            'success' => true,
            'message' => 'Tema berhasil diperbarui.',
        ]);
    }

    public function toggleActive($id)
    {
        $theme = Tema::findOrFail($id);
        $theme->is_active = ! $theme->is_active;
        $theme->save();

        return response()->json([
            'success' => true,
            'message' => 'Status tema '.$theme->name.' berhasil diubah.',
            'is_active' => $theme->is_active,
        ]);
    }

    public function destroy($id)
    {
        $theme = Tema::withCount('undangans')->findOrFail($id);

        if ($theme->undangans_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus! Tema ini sedang digunakan oleh '.$theme->undangans_count.' klien.',
            ], 422);
        }

        if ($theme->thumbnail) {
            Storage::disk('public')->delete($theme->thumbnail);
        }

        $theme->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tema berhasil dihapus.',
        ]);
    }
}
