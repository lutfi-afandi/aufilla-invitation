<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Undangan;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuTamuController extends Controller
{
    public function index($id)
    {
        $invitation = Undangan::with(['acaras'])->findOrFail($id);

        $recentLogs = Tamu::where('undangan_id', $id)
            ->whereNotNull('waktu_hadir')
            ->orderBy('waktu_hadir', 'desc')
            ->limit(5)
            ->get();

        return view('receptionist.buku-tamu', compact('invitation', 'recentLogs'));
    }

    public function search(Request $request, $id)
    {
        $search = $request->input('q');

        $query = Tamu::where('undangan_id', $id);

        if ($search) {
            $query->where('nama_tamu', 'like', "%{$search}%")
                  ->orWhere('kode_qr', 'like', "%{$search}%");
        }

        $tamus = $query->orderBy('nama_tamu')->limit(20)->get();

        return response()->json($tamus);
    }

    public function checkIn(Request $request, $id)
    {
        $request->validate([
            'tamu_id' => 'nullable|integer',
            'kode_qr' => 'nullable|string'
        ]);

        $query = Tamu::where('undangan_id', $id);

        if ($request->filled('kode_qr')) {
            $query->where('kode_qr', $request->kode_qr);
        } elseif ($request->filled('tamu_id')) {
            $query->where('id', $request->tamu_id);
        } else {
            return response()->json(['success' => false, 'message' => 'Data tamu tidak valid.'], 400);
        }

        $tamu = $query->first();

        if (!$tamu) {
            return response()->json(['success' => false, 'message' => 'Tamu tidak ditemukan dalam daftar undangan ini.'], 404);
        }

        if ($tamu->waktu_hadir) {
            return response()->json([
                'success' => false, 
                'message' => 'Tamu sudah melakukan check-in sebelumnya pada ' . $tamu->waktu_hadir->format('d/m/Y H:i'),
                'tamu' => $tamu
            ], 400);
        }

        $tamu->waktu_hadir = now();
        $tamu->save();

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil.',
            'tamu' => $tamu
        ]);
    }

    public function addGuest(Request $request, $id)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_wa' => 'nullable|string|max:20'
        ]);

        $undangan = Undangan::findOrFail($id);

        $tamu = Tamu::create([
            'undangan_id' => $id,
            'nama_tamu' => $request->nama_tamu,
            'slug' => Str::slug($request->nama_tamu),
            'no_whatsapp' => $request->no_wa,
            'kode_qr' => 'QR-' . strtoupper(Str::random(10)),
            'waktu_hadir' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tamu berhasil ditambahkan & di-check-in.',
            'tamu' => $tamu
        ]);
    }

    public function welcomeScreen($id)
    {
        $invitation = Undangan::with(['acaras'])->findOrFail($id);
        $recentGuest = Tamu::where('undangan_id', $id)
            ->whereNotNull('waktu_hadir')
            ->orderBy('waktu_hadir', 'desc')
            ->first();

        return view('receptionist.welcome-screen', compact('invitation', 'recentGuest'));
    }

    public function downloadTemplate()
    {
        $templateData = [
            ['Nama Tamu' => 'Budi Santoso', 'No WhatsApp' => '08123456789'],
            ['Nama Tamu' => 'Ayu Lestari', 'No WhatsApp' => '08987654321']
        ];
        return (new \Rap2hpoutre\FastExcel\FastExcel(collect($templateData)))->download('template_buku_tamu.xlsx');
    }

    public function importExcel(Request $request, $id)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $undangan = Undangan::findOrFail($id);

        $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($request->file('excel_file'));

        foreach ($collection as $row) {
            $nama_tamu = $row['Nama Tamu'] ?? $row['nama tamu'] ?? $row['nama_tamu'] ?? '';
            $no_wa = $row['No WhatsApp'] ?? $row['no whatsapp'] ?? $row['no_wa'] ?? '';

            if (!empty($nama_tamu)) {
                Tamu::create([
                    'undangan_id' => $id,
                    'nama_tamu' => $nama_tamu,
                    'slug' => Str::slug($nama_tamu),
                    'no_whatsapp' => $no_wa,
                    'kode_qr' => 'QR-' . strtoupper(Str::random(10)),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
