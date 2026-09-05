<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriTemaRequest;
use App\Http\Requests\Admin\ReorderKategoriTemaRequest;
use App\Models\KategoriTema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KategoriTemaController extends Controller
{
    /**
     * Display a listing of theme categories.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = KategoriTema::withCount('temas');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('urutan', 'asc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.kategori-themes.partials.table', compact('categories'))->render(),
            ]);
        }

        return view('admin.kategori-themes.index', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(KategoriTemaRequest $request): JsonResponse
    {
        $validated = $request->validated();

        KategoriTema::create([
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'urutan' => $validated['urutan'] ?? 0,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        $categories = KategoriTema::withCount('temas')->orderBy('urutan', 'asc')->orderBy('id', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Kategori tema berhasil ditambahkan.',
            'html' => view('admin.kategori-themes.partials.table', compact('categories'))->render(),
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(KategoriTemaRequest $request, int $id): JsonResponse
    {
        $category = KategoriTema::findOrFail($id);
        $validated = $request->validated();

        $category->update([
            'nama' => $validated['nama'],
            'slug' => $validated['slug'],
            'urutan' => $validated['urutan'] ?? $category->urutan,
            'is_active' => array_key_exists('is_active', $validated) ? $validated['is_active'] : $category->is_active,
        ]);

        $categories = KategoriTema::withCount('temas')->orderBy('urutan', 'asc')->orderBy('id', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Kategori tema berhasil diperbarui.',
            'html' => view('admin.kategori-themes.partials.table', compact('categories'))->render(),
        ]);
    }

    /**
     * Toggle the active status of category.
     */
    public function toggleActive(int $id): JsonResponse
    {
        $category = KategoriTema::findOrFail($id);
        $category->is_active = ! $category->is_active;
        $category->save();

        $categories = KategoriTema::withCount('temas')->orderBy('urutan', 'asc')->orderBy('id', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => "Status kategori {$category->nama} berhasil diubah.",
            'is_active' => $category->is_active,
            'html' => view('admin.kategori-themes.partials.table', compact('categories'))->render(),
        ]);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(int $id): JsonResponse
    {
        $category = KategoriTema::withCount('temas')->findOrFail($id);

        if ($category->temas_count > 0) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menghapus! Kategori ini masih memiliki {$category->temas_count} tema terkait. Pindahkan atau hapus tema terlebih dahulu.",
            ], 422);
        }

        $category->delete();

        $categories = KategoriTema::withCount('temas')->orderBy('urutan', 'asc')->orderBy('id', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Kategori tema berhasil dihapus.',
            'html' => view('admin.kategori-themes.partials.table', compact('categories'))->render(),
        ]);
    }

    /**
     * Reorder theme categories via drag-and-drop.
     */
    public function reorder(ReorderKategoriTemaRequest $request): JsonResponse
    {
        $orders = $request->validated()['orders'];

        DB::transaction(function () use ($orders) {
            foreach ($orders as $item) {
                KategoriTema::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Urutan kategori tema berhasil diperbarui.',
        ]);
    }
}
