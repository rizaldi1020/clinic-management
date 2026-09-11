<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Segoe UI',Arial,sans-serif">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:32px 16px">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#234e52,#319795);border-radius:12px 12px 0 0;padding:32px;text-align:center">
                    <div style="font-size:2rem;margin-bottom:8px">✅</div>
                    <h1 style="color:#fff;margin:0;font-size:1.4rem;font-weight:700">Pembayaran Berhasil</h1>
                    <p style="color:rgba(255,255,255,.75);margin:4px 0 0;font-size:.875rem">Klinik Management</p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="background:#fff;padding:32px">

                    <p style="color:#2d3748;font-size:.95rem;margin:0 0 16px">
                        Halo, <strong>{{ $bill->patient->name }}</strong> 👋
                    </p>
                    <p style="color:#4a5568;font-size:.875rem;line-height:1.6;margin:0 0 24px">
                        Terima kasih! Pembayaran Anda telah berhasil diproses dan tagihan telah dinyatakan <strong style="color:#276749">LUNAS</strong>.
                        Berikut adalah bukti pembayaran Anda:
                    </p>

                    {{-- Invoice badge --}}
                    <div style="background:#f0fff4;border:1.5px solid #9ae6b4;border-radius:10px;padding:20px;text-align:center;margin-bottom:24px">
                        <p style="color:#276749;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin:0 0 4px">No. Invoice</p>
                        <p style="color:#234e52;font-size:1.4rem;font-weight:700;font-family:monospace;margin:0">{{ $bill->invoice_number }}</p>
                        <div style="margin-top:12px;display:inline-block;background:#276749;color:#fff;padding:5px 20px;border-radius:20px;font-size:.82rem;font-weight:700">✓ LUNAS</div>
                    </div>

                    {{-- Detail tagihan --}}
                    <p style="color:#2d3748;font-size:.875rem;font-weight:600;margin:0 0 8px">Rincian Tagihan:</p>
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:24px">
                        <tr style="background:#f7fafc">
                            <td style="padding:8px 14px;font-size:.75rem;font-weight:600;color:#718096;text-transform:uppercase">Deskripsi</td>
                            <td style="padding:8px 14px;font-size:.75rem;font-weight:600;color:#718096;text-transform:uppercase;text-align:right">Subtotal</td>
                        </tr>
                        @foreach($bill->details as $det)
                        <tr>
                            <td style="padding:10px 14px;font-size:.855rem;color:#2d3748;border-top:1px solid #e2e8f0">{{ $det->description }}</td>
                            <td style="padding:10px 14px;font-size:.855rem;color:#2d3748;border-top:1px solid #e2e8f0;text-align:right;white-space:nowrap">Rp {{ number_format($det->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr style="background:#f7fafc">
                            <td style="padding:12px 14px;font-size:.9rem;font-weight:700;color:#1a202c;border-top:2px solid #e2e8f0">Total</td>
                            <td style="padding:12px 14px;font-size:.9rem;font-weight:700;color:#276749;border-top:2px solid #e2e8f0;text-align:right;white-space:nowrap">Rp {{ number_format($bill->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    {{-- Info pembayaran --}}
                    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e2e8f0;border-radius:10px;overflow:hidden;margin-bottom:24px">
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;width:40%">Pasien</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500">{{ $bill->patient->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Dokter</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $bill->appointment->doctor->user->name }}</td>
                        </tr>
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Tanggal Kunjungan</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ $bill->appointment->appointment_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Tgl Pembayaran</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ \Carbon\Carbon::parse($bill->payments->last()?->payment_date)->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        <tr style="background:#f7fafc">
                            <td style="padding:10px 16px;font-size:.78rem;font-weight:600;color:#718096;text-transform:uppercase;border-top:1px solid #e2e8f0">Metode</td>
                            <td style="padding:10px 16px;font-size:.875rem;color:#1a202c;font-weight:500;border-top:1px solid #e2e8f0">{{ ucfirst($bill->payments->last()?->payment_method ?? '—') }}</td>
                        </tr>
                    </table>

                    <p style="color:#4a5568;font-size:.855rem;line-height:1.6;margin:0">
                        Simpan email ini sebagai bukti pembayaran. Terima kasih telah mempercayakan kesehatan Anda kepada kami. 🙏
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
