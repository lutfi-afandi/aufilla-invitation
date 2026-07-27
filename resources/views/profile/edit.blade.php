@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : (auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.receptionist'))

@section('title', 'Profil Pengguna')
@section('page-title', 'Profil Pengguna')

@section('content')
<div class="w-full space-y-6 max-w-7xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden p-6 sm:p-8 border border-slate-100">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden p-6 sm:p-8 border border-slate-100">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
@endsection
