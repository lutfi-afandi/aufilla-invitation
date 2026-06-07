<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TamuController extends Controller
{
    public function index(Request $request)
    {
        $invitation = Auth::user()->invitation;
        if (!$invitation) {
            return response()->json(['data' => []]);
        }

        $query = $invitation->tamus()->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                  ->orWhere('no_wa', 'like', "%{$search}%");
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

        $invitation = Auth::user()->invitation;
        
        if (!\App\Helpers\PackageHelper::canAddGuest($invitation)) {
            $max = \App\Helpers\PackageHelper::getMaxGuests($invitation);
            return response()->json(['error' => 'Anda telah mencapai batas maksimal tamu untuk paket ini ('.$max.' tamu).'], 403);
        }
        
        $tamu = $invitation->tamus()->create([
            'nama_tamu' => $request->nama_tamu,
            'no_wa' => $this->sanitizeWaNumber($request->no_wa),
        ]);

        return response()->json([
            'success' => true,
            'tamu' => $tamu,
            'wa_link' => $this->generateWaLink($invitation->slug, $tamu->nama_tamu)
        ]);
    }

    public function destroy($id)
    {
        $invitation = Auth::user()->invitation;
        $tamu = $invitation->tamus()->findOrFail($id);
        $tamu->delete();

        return response()->json(['success' => true]);
    }

    private function generateWaLink($slug, $namaTamu)
    {
        // Construct the invitation link
        $link = url('/' . $slug . '?to=' . urlencode($namaTamu));
        
        // Default text for sending via WhatsApp
        $text = "Halo, kami mengundang Anda ke pernikahan kami! Silakan lihat detailnya di: " . $link;
        return "https://wa.me/?text=" . urlencode($text);
    }

    public function toggleWa(Request $request, $id)
    {
        $invitation = Auth::user()->invitation;
        $tamu = $invitation->tamus()->findOrFail($id);
        
        $tamu->update([
            'is_wa_sent' => !$tamu->is_wa_sent
        ]);

        return response()->json(['success' => true, 'is_wa_sent' => $tamu->is_wa_sent]);
    }

    public function exportExcel()
    {
        $invitation = Auth::user()->invitation;
        $tamus = $invitation->tamus()->orderBy('created_at', 'desc')->get();

        $filename = "data_tamu_" . date('Ymd_His') . ".xlsx";

        return (new \Rap2hpoutre\FastExcel\FastExcel($tamus))->download($filename, function ($tamu) {
            return [
                'Nama Tamu' => $tamu->nama_tamu,
                'No WhatsApp' => $tamu->no_wa,
                'Status WA' => $tamu->is_wa_sent ? 'Sudah Dikirim' : 'Belum'
            ];
        });
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $invitation = Auth::user()->invitation;
        
        $collection = (new \Rap2hpoutre\FastExcel\FastExcel)->import($request->file('excel_file'));
        
        foreach ($collection as $row) {
            if (!\App\Helpers\PackageHelper::canAddGuest($invitation)) {
                // Berhenti mengimpor jika limit tercapai
                break;
            }

            // Support both exact name and variation
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
