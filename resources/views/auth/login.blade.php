@extends('layouts.guest')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-brand-dark">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username / Email -->
        <div>
            <label for="login" class="block font-medium text-sm text-brand-dark">{{ __('Email atau Username') }}</label>
            <input id="login" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-brand-dark">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-dark shadow-sm focus:ring-brand-light" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-brand-dark hover:text-brand-light hover:underline focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-brand-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-light focus:bg-brand-light active:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand-accent focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Masuk') }}
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-brand-dark hover:text-brand-light hover:underline">Daftar sekarang</a></p>
        </div>
    </form>
@endsection
