<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal untuk otomatis mengubah paket trial yang expired menjadi Basic
use Illuminate\Support\Facades\Schedule;
Schedule::command('invitation:downgrade-expired-trials')->everyMinute(); // Bisa diganti hourly() jika production
