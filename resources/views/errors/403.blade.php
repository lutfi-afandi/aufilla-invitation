<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi - Aufilla Invitation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('assets/css/google-playfair.css') }}" rel="stylesheet">
</head>

<body class="bg-brand-bg min-h-screen flex items-center justify-center p-4 antialiased font-sans">
    <div class="max-w-2xl w-full bg-white rounded-3xl shadow-[0_20px_40px_rgba(21,71,52,0.06)] overflow-hidden border border-brand-accent/20 relative">
        <!-- Decoration -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand-accent to-brand-accent-dark"></div>
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-brand-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-brand-dark/5 rounded-full blur-3xl"></div>

        <div class="p-8 sm:p-12 text-center relative z-10">
            <!-- Icon -->
            <div class="w-20 h-20 mx-auto bg-red-50 rounded-2xl flex items-center justify-center mb-6 border border-red-100 shadow-sm">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Content -->
            <h1 class="text-3xl sm:text-4xl font-bold text-brand-dark mb-4" style="font-family: 'Playfair Display', serif;">
                Oops! Akses Terkunci
            </h1>

            <div class="bg-brand-bg/50 rounded-2xl p-6 mb-8 border border-brand-accent/10">
                <p class="text-gray-600 text-lg leading-relaxed mb-4">
                    {{ $exception->getMessage() ?: 'Masa trial untuk undangan ini telah berakhir atau Anda tidak memiliki akses.' }}
                </p>
                <div class="h-px w-16 bg-brand-accent/30 mx-auto mb-4"></div>
                <p class="text-brand-dark font-medium">
                    Jangan biarkan momen berharga ini terhenti. Aktifkan undangan Anda sekarang dan nikmati kebebasan membagikan kebahagiaan tanpa batasan waktu dan fitur!
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white border-2 border-brand-dark text-brand-dark rounded-xl font-semibold hover:bg-brand-dark hover:text-white transition-all duration-300">
                    Buat Undangan Anda
                </a>
                <a href="https://wa.me/{{ config('app.activation_wa') ?? '6285171097138' }}?text={{ urlencode('Halo Admin Aufilla, saya tertarik untuk membuat Undangan Digital.') }}" target="_blank" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-brand-accent to-brand-accent-dark text-white rounded-xl font-semibold hover:shadow-[0_8px_25px_rgba(212,175,55,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hubungi via WA
                </a>
            </div>
        </div>

        <!-- Footer info -->
        <div class="bg-brand-dark p-4 text-center">
            <p class="text-white/60 text-sm">
                &copy; {{ date('Y') }} Aufilla Invitation. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>