@extends('layouts.client')

@section('title', 'Overview - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    <!-- Welcome Panel (Zoo Style) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-dark to-brand-medium text-white p-8 sm:p-10 border border-brand-accent/20 shadow-[0_10px_30px_rgba(10,34,20,0.15)] mb-8">
        <div class="relative z-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-brand-accent mb-3" style="font-family: 'Playfair Display', serif;">Selamat Datang di Aufilla!</h2>
            <p class="text-white/85 max-w-2xl text-lg leading-relaxed mb-6">
                @if($invitation->status === 'trial')
                    @if($invitation->trial_habis_at && $invitation->trial_habis_at->isPast())
                        Masa trial Anda telah habis. Beberapa fitur kini terkunci dan undangan Anda mungkin tidak dapat diakses secara publik. Silakan lakukan aktivasi agar undangan dapat digunakan tanpa batas.
                    @else
                        Anda saat ini sedang dalam masa trial (Kedaluwarsa: <strong>{{ $invitation->trial_habis_at ? $invitation->trial_habis_at->format('d M Y, H:i') : '-' }}</strong>). Segera lakukan aktivasi agar undangan dapat disebar tanpa batasan waktu.
                    @endif
                @elseif($invitation->status === 'aktif' && $invitation->package)
                    Selamat! Paket <strong>{{ $invitation->package->name }}</strong> Anda aktif hingga {{ $invitation->package->active_days > 10000 ? 'selamanya' : $invitation->created_at->addDays($invitation->package->active_days)->format('d M Y') }}. 
                    @if($invitation->package->name === 'Basic')
                        Tingkatkan ke paket Premium atau VIP untuk membuka fitur Cerita Cinta dan Musik Latar.
                    @elseif($invitation->package->name === 'Premium')
                        Nikmati fitur Cerita Cinta dan Musik Latar. Tingkatkan ke VIP untuk foto galeri tanpa batas.
                    @else
                        Anda kini menikmati fitur VIP tanpa batas. Sebarkan momen kebahagiaan Anda!
                    @endif
                @else
                    Undangan Anda saat ini berstatus {{ $invitation->status }}. Silakan hubungi Admin untuk informasi lebih lanjut.
                @endif
            </p>
            <a href="https://wa.me/{{ config('app.activation_wa') }}?text={{ urlencode('Halo Admin Aufilla, saya ingin aktivasi undangan atas nama username: ' . Auth::user()->username) }}" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#a28056] text-white font-semibold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(197,168,128,0.3)] hover:shadow-[0_6px_20px_rgba(197,168,128,0.4)] transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                Hubungi WhatsApp
            </a>
        </div>
        <!-- Ornament Pattern (Simulated with absolute div/svg) -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-accent opacity-5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-10 right-20 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tamu -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#588b8b]/10 text-[#588b8b]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">{{ $invitation->tamus()->count() }}</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Total Tamu</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>

        <!-- Reservasi -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-brand-dark/5 text-brand-dark">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">0</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Hadir</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>
        
        <!-- Ucapan -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-brand-accent/15 text-brand-accent-dark">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">0</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Ucapan</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>
    </div>
</div>
@endsection
