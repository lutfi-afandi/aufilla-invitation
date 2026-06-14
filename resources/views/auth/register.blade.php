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

        <!-- Username / Link Undangan -->
        <div class="mt-4">
            <label for="username" class="block font-medium text-sm text-brand-dark">{{ __('Link Undangan Anda') }}</label>
            <input id="username" class="block mt-1 w-full border-gray-300 focus:border-brand-light focus:ring-brand-light rounded-md shadow-sm" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="romeo-juliet" />
            
            <div id="username-preview-container" class="mt-3 hidden transition-all duration-300">
                <div class="flex flex-col gap-1.5 p-3.5 bg-gray-50 border border-gray-200 rounded-lg shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2 text-[12px] font-medium">
                        <div class="w-5 h-5 rounded-full bg-brand-light/10 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <span class="text-gray-500">Akses URL:</span>
                        <span class="text-brand-dark font-bold truncate">{{ request()->getSchemeAndHttpHost() }}/<span id="username-value" class="text-brand-dark underline decoration-brand-dark/30 underline-offset-2"></span></span>
                    </div>
                    <div id="username-feedback" class="text-[12px] font-medium pl-7"></div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        const coupleNameInput = document.getElementById('couple_name');
        const feedback = document.getElementById('username-feedback');
        const submitBtn = document.querySelector('button[type="submit"]');
        let timeout = null;

        // Auto generate slug from couple name initially if username is empty
        coupleNameInput.addEventListener('keyup', function() {
            if (!usernameInput.value || usernameInput.dataset.autoGenerated === 'true') {
                const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
                usernameInput.value = slug;
                usernameInput.dataset.autoGenerated = 'true';
                
                const previewValue = document.getElementById('username-value');
                const previewContainer = document.getElementById('username-preview-container');
                if (slug.length > 0) {
                    previewValue.textContent = slug;
                    previewContainer.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }
                
                checkUsername(slug);
            }
        });

        usernameInput.addEventListener('keyup', function() {
            this.dataset.autoGenerated = 'false';
            
            // Format to slug instantly
            let val = this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-');
            if (this.value !== val) {
                this.value = val;
            }

            const previewValue = document.getElementById('username-value');
            const previewContainer = document.getElementById('username-preview-container');

            if (val.length > 0) {
                previewValue.textContent = val;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (val.length > 0) {
                    checkUsername(val);
                } else {
                    feedback.innerHTML = '';
                    submitBtn.disabled = true;
                }
            }, 500);
        });

        function checkUsername(username) {
            if (username.length < 3) {
                feedback.className = 'text-[12px] font-medium text-amber-600 pl-7';
                feedback.innerHTML = 'URL terlalu pendek (minimal 3 karakter)';
                submitBtn.disabled = true;
                return;
            }

            feedback.className = 'text-[12px] font-medium text-gray-500 pl-7';
            feedback.innerHTML = 'Mengecek ketersediaan...';

            fetch(`/api/check-username?username=${encodeURIComponent(username)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.available) {
                        feedback.className = 'text-[12px] font-medium text-emerald-600 pl-7';
                        feedback.innerHTML = `<svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> ${data.message}`;
                        submitBtn.disabled = false;
                    } else {
                        feedback.className = 'text-[12px] font-medium text-red-500 pl-7';
                        feedback.innerHTML = `<svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> ${data.message}`;
                        submitBtn.disabled = true;
                    }
                })
                .catch(err => {
                    feedback.className = 'text-[12px] font-medium text-gray-500 pl-7';
                    feedback.innerHTML = 'Gagal mengecek URL.';
                });
        }
    });
</script>
@endpush
