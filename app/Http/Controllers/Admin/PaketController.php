<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::withCount('undangans')->orderBy('price', 'asc')->get();
        return view('admin.pakets.index', compact('pakets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'active_days' => 'required|integer|min:1',
            'max_gallery_photos' => 'required|integer|min:0',
            'has_love_story' => 'boolean',
            'can_custom_music' => 'boolean',
            'is_priority_support' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['has_love_story'] = $request->has('has_love_story');
        $validated['can_custom_music'] = $request->has('can_custom_music');
        $validated['is_priority_support'] = $request->has('is_priority_support');

        Paket::create($validated);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'active_days' => 'required|integer|min:1',
            'max_gallery_photos' => 'required|integer|min:0',
            'has_love_story' => 'boolean',
            'can_custom_music' => 'boolean',
            'is_priority_support' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $validated['has_love_story'] = $request->has('has_love_story');
        $validated['can_custom_music'] = $request->has('can_custom_music');
        $validated['is_priority_support'] = $request->has('is_priority_support');

        $paket->update($validated);

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $paket = Paket::withCount('undangans')->findOrFail($id);

        if ($paket->undangans_count > 0) {
            return redirect()->route('admin.pakets.index')->with('error', 'Paket tidak dapat dihapus karena digunakan oleh ' . $paket->undangans_count . ' undangan.');
        }

        $paket->delete();

        return redirect()->route('admin.pakets.index')->with('success', 'Paket berhasil dihapus!');
    }
}
