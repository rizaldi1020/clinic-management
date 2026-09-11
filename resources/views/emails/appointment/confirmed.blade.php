<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Janji Temu</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:32px 16px">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#0f4c81,#1a6db5);border-radius:12px 12px 0 0;padding:32px;text-align:center">
                    <div style="font-size:2rem;margin-bottom:8px">🏥</div>
                    <h1 style="color:#fff;margin:0;font-size:1.4rem;font-weight:700">Klinik Management</h1>
                    <p style="color:rgba(255,255,255,.75);margin:4px 0 0;font-size:.875rem">Konfirmasi Janji Temu</p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="background:#fff;padding:32px">

                    <p style="color:#2d3748;font-size:.95rem;margin:0 0 16px">
                        Halo, <strong>{{ $appointment->patient->name }}</strong> 👋
                    </p>
                    <p style="color:#4a5568;font-size:.875rem;line-height:1.6;margin:0 0 24px">
                        Janji temu Anda telah berhasil dibuat. Berikut adalah detail kunjungan Anda:
                    </p>

                    {{-- Kode Appointment --}}
                    <div style="background:#ebf8ff;border:1.5px solid #bee3f8;border-radius:10px;padding:16px;text-align:center;margin-bottom:24px">
                        <p style="color:#718096;font-size:.78rem;margin:0 0 4px;text-transform:uppercase;letter-spacing:.05em">Kode Janji Temu</p>
                        <p style="color:#1a6db5;font-size:1.5rem;font-weight:700;font-family:monospace;margin:0">{{ $appointment->appointment_code }}</p>
                    </div>

                    {{-- Detail --}}
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:24px">
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;width:40%">Pasien</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500">{{ $appointment->patient->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-top:1px solid #e2e8f0">Dokter</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $appointment->doctor->user->name }}</td>
                        </tr>
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-top:1px solid #e2e8f0">Poli</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $appointment->department->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-top:1px solid #e2e8f0">Tanggal</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $appointment->appointment_date->format('l, d F Y') }}</td>
                        </tr>
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-top:1px solid #e2e8f0">Jam</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ substr($appointment->appointment_time, 0, 5) }} WIB</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-top:1px solid #e2e8f0">Biaya Konsultasi</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">Rp {{ number_format($appointment->doctor->consultation_fee, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    {{-- Keluhan --}}
                    @if($appointment->complaint)
                    <div style="background:#fffff0;border:1px solid #f6e05e;border-radius:8px;padding:12px 16px;margin-bottom:24px">
                        <p style="color:#744210;font-size:.78rem;font-weight:600;text-transform:uppercase;margin:0 0 4px">Keluhan yang disampaikan:</p>
                        <p style="color:#744210;font-size:.875rem;margin:0">{{ $appointment->complaint }}</p>
                    </div>
                    @endif

                    {{-- Tips --}}
                    <div style="background:#f7fafc;border-radius:8px;padding:16px;margin-bottom:24px">
                        <p style="color:#2d3748;font-size:.875rem;font-weight:600;margin:0 0 8px">📋 Yang perlu disiapkan:</p>
                        <ul style="color:#4a5568;font-size:.855rem;margin:0;padding-left:20px;line-height:1.8">
                            <li>Kartu identitas (KTP/SIM)</li>
                            <li>Kartu pasien / No. Rekam Medis</li>
                            <li>Hadir 15 menit sebelum jadwal</li>
                            @if($appointment->patient->allergy)
                                <li>⚠️ Informasikan alergi Anda: <strong>{{ $appointment->patient->allergy }}</strong></li>
                            @endif
                        </ul>
                    </div>

                    <p style="color:#4a5568;font-size:.855rem;line-height:1.6;margin:0">
                        Jika ingin membatalkan atau mengubah jadwal, silakan hubungi kami setidaknya
                        <strong>2 jam sebelum</strong> waktu yang dijadwalkan.
                    </p>

                </td>
            </tr>

            {{-- Footer --}}
            <tr>
                <td style="background:#0f2942;border-radius:0 0 12px 12px;padding:20px 32px;text-align:center">
                    <p style="color:rgba(255,255,255,.6);font-size:.78rem;margin:0">
                        © {{ date('Y') }} Klinik Management &nbsp;·&nbsp; Email ini dikirim otomatis, jangan balas email ini
                    </p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>

</body>
</html>
