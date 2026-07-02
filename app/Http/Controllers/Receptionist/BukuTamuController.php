<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuTamuController extends Controller
{
    /**
     * Tampilkan halaman Buku Tamu (Receptionist Control Panel)
     */
    public function index($id)
    {
        $invitation = Invitation::with(['acaras'])->findOrFail($id);

        $recentLogs = Tamu::where('invitation_id', $id)
            ->whereNotNull('waktu_hadir')
            ->orderBy('waktu_hadir', 'desc')
            ->limit(5)
            ->get();

        return view('receptionist.buku-tamu', compact('invitation', 'recentLogs'));
    }

    /**
     * Pencarian manual tamu (AJAX)
     */
    public function search(Request $request, $id)
    {
        $search = $request->input('q');

        $query = Tamu::where('invitation_id', $id);

        if ($search) {
            $query->where('nama_tamu', 'like', "%{$search}%")
                  ->orWhere('kode_qr', 'like', "%{$search}%");
        }

        $tamus = $query->orderBy('nama_tamu')->limit(20)->get();

        return response()->json($tamus);
    }

    /**
     * Check-in tamu (via QR scan atau manual click)
     */
    public function checkIn(Request $request, $id)
    {
        $request->validate([
            'tamu_id' => 'nullable|integer',
            'kode_qr' => 'nullable|string'
        ]);

        $query = Tamu::where('invitation_id', $id);

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
            ], 400); // Bad request but we still return tamu to show they are here. Actually let's just make it success = false so JS can warn. Wait, let's return 200 with a warning status so the frontend can handle it nicely.
        }

        $tamu->waktu_hadir = now();
        $tamu->save();

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil.',
            'tamu' => $tamu
        ]);
    }

    /**
     * Tambah tamu baru secara on-the-spot dan otomatis check-in
     */
    public function addGuest(Request $request, $id)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'no_wa' => 'nullable|string|max:20'
        ]);

        $tamu = Tamu::create([
            'invitation_id' => $id,
            'nama_tamu' => $request->nama_tamu,
            'no_wa' => $request->no_wa,
            'waktu_hadir' => now() // Langsung check-in
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tamu baru berhasil ditambahkan dan di-check-in.',
            'tamu' => $tamu
        ]);
    }

    public function welcomeScreen($id)
    {
        $invitation = Invitation::with('galeris')->findOrFail($id);

        return view('receptionist.welcome-screen', compact('invitation'));
    }

    public function uploadBg(Request $request, $id)
    {
        $invitation = Invitation::findOrFail($id);

        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:6144',
        ]);

        if ($request->hasFile('background_image')) {
            $path = $request->file('background_image')->store('welcome_screens', 'public');
            
            // Save to invitation settings
            $invitation->update([
                'welcome_bg_path' => $path
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Background berhasil diunggah!',
                'path' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah file.']);
    }

    public function importExcel(Request $request, $id)
    {
        $invitation = Invitation::findOrFail($id);

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($request->file('excel_file'));
        
        foreach ($collection as $row) {
            if (!\App\Helpers\PackageHelper::canAddGuest($invitation)) {
                break;
            }

            $nama_tamu = $row['Nama Tamu'] ?? $row['nama tamu'] ?? $row['nama_tamu'] ?? '';
            $no_wa = $row['No WhatsApp'] ?? $row['no whatsapp'] ?? $row['no_wa'] ?? '';

            if (!empty($nama_tamu)) {
                $invitation->tamus()->create([
                    'nama_tamu' => $nama_tamu,
                    'no_wa' => $this->sanitizeWaNumber($no_wa)
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
