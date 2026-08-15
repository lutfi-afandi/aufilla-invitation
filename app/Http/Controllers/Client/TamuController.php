<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TamuController extends Controller
{
    public function index(Request $request)
    {
        $undangan = Auth::user()->undangans()->first();
        if (!$undangan) {
            return response()->json(['data' => []]);
        }

        $query = $undangan->tamus()->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                  ->orWhere('no_whatsapp', 'like', "%{$search}%");
            });
        }

        $tamus = $query->paginate(10);
        return response()->json($tamus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_wa' => 'nullable|string|max:20',
        ]);

        $undangan = Auth::user()->undangans()->first();
        
        $tamu = $undangan->tamus()->create([
            'nama_tamu' => $request->nama_tamu,
            'slug' => Str::slug($request->nama_tamu),
            'no_whatsapp' => $this->sanitizeWaNumber($request->no_wa),
            'kode_qr' => 'QR-' . strtoupper(Str::random(10)),
        ]);

        return response()->json([
            'success' => true,
            'tamu' => $tamu,
            'wa_link' => $this->generateWaLink($undangan->slug, $tamu->nama_tamu)
        ]);
    }

    public function destroy($id)
    {
        $undangan = Auth::user()->undangans()->first();
        $tamu = $undangan->tamus()->findOrFail($id);
        $tamu->delete();

        return response()->json(['success' => true]);
    }

    private function generateWaLink($slug, $namaTamu)
    {
        $link = url('/' . $slug . '?to=' . urlencode($namaTamu));
        $text = "Halo, kami mengundang Anda ke pernikahan kami! Silakan lihat detailnya di: " . $link;
        return "https://wa.me/?text=" . urlencode($text);
    }

    public function toggleWa(Request $request, $id)
    {
        $undangan = Auth::user()->undangans()->first();
        $tamu = $undangan->tamus()->findOrFail($id);
        
        $tamu->update([
            'is_wa_sent' => !$tamu->is_wa_sent
        ]);

        return response()->json(['success' => true, 'is_wa_sent' => $tamu->is_wa_sent]);
    }

    public function exportExcel()
    {
        $undangan = Auth::user()->undangans()->first();
        $tamus = $undangan->tamus()->orderBy('created_at', 'desc')->get();

        $filename = "data_tamu_" . date('Ymd_His') . ".xlsx";

        return (new \Rap2hpoutre\FastExcel\FastExcel($tamus))->download($filename, function ($tamu) {
            return [
                'Nama Tamu' => $tamu->nama_tamu,
                'No WhatsApp' => $tamu->no_whatsapp,
                'Status WA' => $tamu->is_wa_sent ? 'Sudah Dikirim' : 'Belum'
            ];
        });
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $undangan = Auth::user()->undangans()->first();
        
        $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($request->file('excel_file'));
        
        foreach ($collection as $row) {
            $nama_tamu = $row['Nama Tamu'] ?? $row['nama tamu'] ?? $row['nama_tamu'] ?? '';
            $no_wa = $row['No WhatsApp'] ?? $row['no whatsapp'] ?? $row['no_wa'] ?? '';

            if (!empty($nama_tamu)) {
                $undangan->tamus()->create([
                    'nama_tamu' => $nama_tamu,
                    'slug' => Str::slug($nama_tamu),
                    'no_whatsapp' => $this->sanitizeWaNumber($no_wa),
                    'kode_qr' => 'QR-' . strtoupper(Str::random(10)),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function downloadTemplate()
    {
        $templateData = [
            ['Nama Tamu' => 'Budi Santoso', 'No WhatsApp' => '08123456789'],
            ['Nama Tamu' => 'Ayu Lestari', 'No WhatsApp' => '08987654321']
        ];
        return (new \Rap2hpoutre\FastExcel\FastExcel(collect($templateData)))->download('template_tamu.xlsx');
    }

    private function sanitizeWaNumber($no_wa)
    {
        if (empty($no_wa)) return null;
        $no_wa = preg_replace('/[^0-9+]/', '', $no_wa);
        if (str_starts_with($no_wa, '+62')) {
            return '0' . substr($no_wa, 3);
        } elseif (str_starts_with($no_wa, '62')) {
            return '0' . substr($no_wa, 2);
        }
        return $no_wa;
    }
}
