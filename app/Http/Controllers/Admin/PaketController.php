<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaketRequest;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $pakets = Paket::withCount('undangans')->orderBy('price', 'asc')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'html' => view('admin.pakets.partials.list', compact('pakets'))->render(),
            ]);
        }

        return view('admin.pakets.index', compact('pakets'));
    }

    public function store(PaketRequest $request)
    {
        Paket::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Paket berhasil ditambahkan!',
        ]);
    }

    public function update(PaketRequest $request, $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Paket berhasil diperbarui!',
        ]);
    }

    public function destroy($id)
    {
        $paket = Paket::withCount('undangans')->findOrFail($id);

        if ($paket->undangans_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Paket tidak dapat dihapus karena digunakan oleh '.$paket->undangans_count.' undangan.',
            ], 422);
        }

        $paket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paket berhasil dihapus!',
        ]);
    }
}
