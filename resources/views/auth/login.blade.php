@extends('layouts.guest')

@section('content')
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-serif text-brand-dark mb-2">Selamat Datang</h2>
        <p class="text-[13px] text-brand-dark/60 font-medium tracking-wide">Silakan masuk ke akun Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Username / Email -->
        <div>
            <label for="login" class="block font-medium text-[11px] uppercase tracking-widest text-brand-dark/80 mb-2">{{ __('Email / Username') }}</label>
            <input id="login" class="block w-full px-4 py-3 bg-brand-bg/50 border border-brand-dark/10 focus:border-brand-accent focus:ring-brand-accent focus:ring-1 rounded-xl shadow-sm text-sm transition-all duration-300" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="Masukkan email atau username" />
            <x-input-error :messages="$errors->get('login')" class="mt-2 text-[11px]" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-[11px] uppercase tracking-widest text-brand-dark/80 mb-2">{{ __('Password') }}</label>
            <input id="password" class="block w-full px-4 py-3 bg-brand-bg/50 border border-brand-dark/10 focus:border-brand-accent focus:ring-brand-accent focus:ring-1 rounded-xl shadow-sm text-sm transition-all duration-300"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[11px]" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer h-4 w-4 cursor-pointer appearance-none rounded border border-brand-dark/20 checked:border-brand-accent checked:bg-brand-accent transition-all" name="remember">
                    <div class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <span class="ms-2 text-[12px] font-medium text-brand-dark/70 group-hover:text-brand-dark transition-colors">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[12px] font-medium text-brand-dark/60 hover:text-brand-accent transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-brand-dark hover:bg-brand-accent text-white rounded-xl text-[12px] font-bold uppercase tracking-widest shadow-lg shadow-brand-dark/20 hover:shadow-brand-accent/30 hover:-translate-y-0.5 transition-all duration-300 group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/20 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 transform -translate-x-full group-hover:translate-x-full ease-out"></div>
                <span class="relative z-10">{{ __('Masuk') }}</span>
            </button>
        </div>
        
        <div class="mt-8 text-center border-t border-brand-dark/5 pt-6">
            <p class="text-[12px] text-brand-dark/60 font-medium">Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-brand-dark hover:text-brand-accent transition-colors ml-1 uppercase tracking-wider text-[11px]">Daftar Sekarang</a></p>
        </div>
    </form>
@endsection
