<?php

use Illuminate\Support\Facades\Schedule;

// Kirim email pengingat setiap hari jam 08.00 pagi
Schedule::command('klinik:send-reminders')->dailyAt('08:00');
