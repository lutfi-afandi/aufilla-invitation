<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Perbarui informasi profil akun Anda dan alamat email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="username" class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Username</label>
            <input id="username" name="username" type="text" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" value="{{ old('username', $user->username) }}" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <label for="email" class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Email</label>
            <input id="email" name="email" type="email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" value="{{ old('email', $user->email) }}" autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-accent">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark focus:outline-none focus:ring-2 focus:ring-admin-accent focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-medium"
                >Berhasil disimpan.</p>
            @endif
        </div>
    </form>
</section>
