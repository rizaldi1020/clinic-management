<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature   = 'klinik:send-reminders';
    protected $description = 'Kirim email pengingat janji temu H-1';

    public function handle(): void
    {
        $tomorrow = now()->addDay()->toDateString();

        $appointments = Appointment::with(['patient', 'doctor.user', 'department'])
            ->whereDate('appointment_date', $tomorrow)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('Tidak ada janji temu besok yang perlu diingatkan.');
            return;
        }

        $sent = 0;
        foreach ($appointments as $apt) {
            $email = $apt->patient->user?->email;

            if (!$email) {
                $this->warn("Skip: {$apt->patient->name} — tidak punya akun email.");
                continue;
            }

            try {
                Mail::to($email)->send(new AppointmentReminder($apt));
                $sent++;
                $this->info("✅ Terkirim ke {$apt->patient->name} ({$email})");
            } catch (\Exception $e) {
                $this->error("❌ Gagal kirim ke {$email}: " . $e->getMessage());
            }
        }

        $this->info("Selesai. {$sent} dari {$appointments->count()} email terkirim.");
    }
}
