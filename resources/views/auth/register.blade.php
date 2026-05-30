@extends('layouts.guest')

@section('content')
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-brand-dark">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar untuk memulai membuat undangan digital Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Couple Name -->
        <div>
            <label for="couple_name" class="block font-medium text-sm text-brand-dark">{{ __('Nama Pasangan (Contoh: Romeo & Juliet)') }}</label>
            <input id="couple_name" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm" type="text" name="couple_name" :value="old('couple_name')" required autofocus />
            <x-input-error :messages="$errors->get('couple_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-brand-dark">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-brand-dark">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-brand-dark">{{ __('Konfirmasi Password') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-brand-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-light focus:bg-brand-light active:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand-accent focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Daftar') }}
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-brand-dark hover:text-brand-light hover:underline">Masuk di sini</a></p>
        </div>
    </form>
@endsection
