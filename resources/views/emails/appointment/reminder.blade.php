<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Janji Temu</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:32px 16px">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#744210,#dd6b20);border-radius:12px 12px 0 0;padding:32px;text-align:center">
                    <div style="font-size:2rem;margin-bottom:8px">⏰</div>
                    <h1 style="color:#fff;margin:0;font-size:1.4rem;font-weight:700">Pengingat Janji Temu</h1>
                    <p style="color:rgba(255,255,255,.75);margin:4px 0 0;font-size:.875rem">Klinik Management</p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="background:#fff;padding:32px">

                    <p style="color:#2d3748;font-size:.95rem;margin:0 0 16px">
                        Halo, <strong>{{ $appointment->patient->name }}</strong> 👋
                    </p>
                    <p style="color:#4a5568;font-size:.875rem;line-height:1.6;margin:0 0 24px">
                        Ini adalah pengingat bahwa Anda memiliki janji temu dengan dokter <strong>besok</strong>.
                        Pastikan Anda sudah siap!
                    </p>

                    {{-- Highlight besok --}}
                    <div style="background:#fffbeb;border:1.5px solid #f6e05e;border-radius:10px;padding:20px;text-align:center;margin-bottom:24px">
                        <p style="color:#744210;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin:0 0 8px">Jadwal Besok</p>
                        <p style="color:#c05621;font-size:1.75rem;font-weight:700;margin:0">{{ $appointment->appointment_date->format('d F Y') }}</p>
                        <p style="color:#744210;font-size:1.1rem;font-weight:600;margin:4px 0 0">⏰ {{ substr($appointment->appointment_time, 0, 5) }} WIB</p>
                        <p style="color:#744210;font-size:.855rem;margin:8px 0 0;font-family:monospace">{{ $appointment->appointment_code }}</p>
                    </div>

                    {{-- Detail --}}
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:24px">
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;width:40%">Dokter</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500">{{ $appointment->doctor->user->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Poli</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $appointment->department->name }}</td>
                        </tr>
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Status</td>
                            <td style="padding:10px 16px;font-size:.875rem;font-weight:500;border-top:1px solid #e2e8f0">
                                <span style="background:#ebf8ff;color:#2b6cb0;padding:3px 10px;border-radius:20px;font-size:.78rem;font-weight:600">{{ ucfirst($appointment->status) }}</span>
                            </td>
                        </tr>
                    </table>

                    {{-- Checklist --}}
                    <div style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:16px;margin-bottom:24px">
                        <p style="color:#276749;font-size:.875rem;font-weight:600;margin:0 0 10px">✅ Checklist sebelum datang:</p>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            @foreach(['Kartu identitas (KTP)', 'Kartu pasien / No. RM', 'Hadir 15 menit lebih awal', 'Sarapan/makan dulu jika diperlukan'] as $item)
                            <tr>
                                <td style="padding:3px 0;color:#276749;font-size:.855rem">☐ &nbsp;{{ $item }}</td>
                            </tr>
                            @endforeach
                            @if($appointment->patient->allergy)
                            <tr>
                                <td style="padding:3px 0;color:#c53030;font-size:.855rem">⚠️ &nbsp;Beritahu dokter tentang alergi: <strong>{{ $appointment->patient->allergy }}</strong></td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <p style="color:#718096;font-size:.82rem;line-height:1.6;margin:0;border-top:1px solid #e2e8f0;padding-top:16px">
                        Perlu membatalkan? Hubungi kami segera. Pembatalan minimal 2 jam sebelum jadwal.
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
