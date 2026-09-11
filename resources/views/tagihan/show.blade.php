@extends('layouts.app')
@section('title','Detail Tagihan')
@section('page-title','Detail Tagihan')
@section('breadcrumb','Admin / Tagihan / Detail')

@section('sidebar-menu')
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('tagihan.index') }}" class="active"><span class="menu-icon">🧾</span> Tagihan</a></li>
@endsection

@push('styles')
<style>
    .actions{display:flex;gap:.6rem;margin-bottom:1rem;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .btn-success{background:#f0fff4;color:#276749;border:1px solid #9ae6b4}.btn-success:hover{background:#c6f6d5}

    /* Invoice header */
    .inv-header{background:linear-gradient(135deg,#0f2942,#1a6db5);border-radius:12px;padding:1.5rem;color:#fff;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem}
    .inv-no{font-family:monospace;font-size:.9rem;background:rgba(255,255,255,.15);padding:.3rem .75rem;border-radius:6px;margin-bottom:.4rem;display:inline-block}
    .inv-header h3{font-size:1.2rem;font-weight:700;margin-bottom:.2rem}
    .inv-header p{font-size:.85rem;opacity:.75}
    .inv-amount{text-align:right}
    .inv-amount .label{font-size:.78rem;opacity:.7;margin-bottom:.2rem}
    .inv-amount .amount{font-size:1.75rem;font-weight:700}

    .badge{display:inline-block;padding:.25rem .75rem;border-radius:20px;font-size:.82rem;font-weight:600}
    .s-belum_dibayar{background:#fff5f5;color:#c53030}
    .s-lunas{background:#f0fff4;color:#276749}
    .s-dibatalkan{background:#edf2f7;color:#718096}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
    .icard{border:1.5px solid #e2e8f0;border-radius:10px;padding:1rem}
    .icard h4{font-size:.73rem;font-weight:600;color:#a0aec0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem}
    .irow{display:flex;gap:.5rem;margin-bottom:.4rem;font-size:.875rem}
    .irow label{color:#718096;min-width:110px;flex-shrink:0;font-size:.82rem}
    .irow span{color:#1a202c;font-weight:500}

    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}

    table{width:100%;border-collapse:collapse;font-size:.875rem}
    thead th{padding:.65rem 1rem;text-align:left;font-size:.73rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0}
    tbody td{padding:.7rem 1rem;border-bottom:1px solid #f7fafc;color:#2d3748}
    .total-row td{font-weight:700;background:#f7fafc;border-bottom:none}

    /* Pembayaran */
    .payment-row{display:flex;align-items:center;gap:1rem;padding:.65rem 0;border-bottom:1px solid #f7fafc;font-size:.875rem}
    .payment-row:last-child{border-bottom:none}
    .payment-method{display:inline-block;background:#ebf8ff;color:#2b6cb0;border-radius:20px;padding:.15rem .55rem;font-size:.75rem;font-weight:600;text-transform:capitalize}

    /* Form pembayaran */
    .pay-form{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.65rem;align-items:end;margin-top:.75rem}
    .pay-form .fg{display:flex;flex-direction:column;gap:.3rem}
    .pay-form label{font-size:.78rem;font-weight:500;color:#4a5568}
    .pay-form input,.pay-form select{padding:.5rem .75rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.85rem;font-family:inherit;outline:none}
    .pay-form input:focus,.pay-form select:focus{border-color:#1a6db5}

    .sisa-box{border:1.5px solid #e2e8f0;border-radius:8px;padding:.75rem 1rem;margin-bottom:.75rem;display:flex;justify-content:space-between;align-items:center;font-size:.875rem}
    .sisa-box .label{color:#718096}
    .sisa-box .value{font-size:1.1rem;font-weight:700;color:#c53030}
    .sisa-box.lunas .value{color:#276749}
</style>
@endpush

@section('content')

<div class="actions">
    <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('appointment.show', $tagihan->appointment) }}" class="btn btn-secondary">📅 Lihat Janji Temu</a>
    @if($tagihan->status !== 'lunas')
        <form method="POST" action="{{ route('tagihan.destroy', $tagihan) }}"
              onsubmit="return confirm('Hapus tagihan ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑 Hapus</button>
        </form>
    @endif
</div>

{{-- Invoice Header --}}
<div class="inv-header">
    <div>
        <div class="inv-no">{{ $tagihan->invoice_number }}</div>
        <h3>{{ $tagihan->patient->name }}</h3>
        <p>No. RM: {{ $tagihan->patient->no_rm }}</p>
        <div style="margin-top:.5rem">
            <span class="badge s-{{ $tagihan->status }}">{{ ucfirst(str_replace('_',' ',$tagihan->status)) }}</span>
        </div>
    </div>
    <div class="inv-amount">
        <div class="label">Total Tagihan</div>
        <div class="amount">Rp {{ number_format($tagihan->total_amount,0,',','.') }}</div>
        <div style="font-size:.82rem;opacity:.75;margin-top:.25rem">{{ \Carbon\Carbon::parse($tagihan->bill_date)->format('d M Y') }}</div>
    </div>
</div>

{{-- Info Grid --}}
<div class="info-grid">
    <div class="icard">
        <h4>🧑‍🦽 Pasien</h4>
        <div class="irow"><label>Nama</label><span>{{ $tagihan->patient->name }}</span></div>
        <div class="irow"><label>No. RM</label><span>{{ $tagihan->patient->no_rm }}</span></div>
        <div class="irow"><label>NIK</label><span>{{ $tagihan->patient->nik }}</span></div>
    </div>
    <div class="icard">
        <h4>👨‍⚕️ Layanan</h4>
        <div class="irow"><label>Dokter</label><span>{{ $tagihan->appointment->doctor->user->name }}</span></div>
        <div class="irow"><label>Poli</label><span>{{ $tagihan->appointment->department->name }}</span></div>
        <div class="irow"><label>Tgl Kunjungan</label><span>{{ $tagihan->appointment->appointment_date->format('d M Y') }}</span></div>
    </div>
</div>

{{-- Rincian Tagihan --}}
<div class="card">
    <div class="section-title">Rincian Tagihan</div>
    <table>
        <thead>
            <tr><th>#</th><th>Deskripsi</th><th>Qty</th><th>Harga Satuan</th><th style="text-align:right">Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach($tagihan->details as $i => $det)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $det->description }}</td>
                <td>{{ $det->qty }}</td>
                <td>Rp {{ number_format($det->price,0,',','.') }}</td>
                <td style="text-align:right">Rp {{ number_format($det->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" style="text-align:right;padding-right:1rem">Total:</td>
                <td style="text-align:right">Rp {{ number_format($tagihan->total_amount,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Pembayaran --}}
<div class="card">
    <div class="section-title">Riwayat Pembayaran ({{ $tagihan->payments->count() }})</div>

    @php $totalPaid = $tagihan->payments->sum('amount'); $sisa = $tagihan->total_amount - $totalPaid; @endphp
    <div class="sisa-box {{ $sisa <= 0 ? 'lunas' : '' }}">
        <div>
            <div class="label">Sudah Dibayar</div>
            <div style="font-weight:600">Rp {{ number_format($totalPaid,0,',','.') }}</div>
        </div>
        <div style="text-align:center">
            <div class="label">Sisa</div>
            <div class="value">{{ $sisa > 0 ? 'Rp '.number_format($sisa,0,',','.') : '✓ LUNAS' }}</div>
        </div>
        <div style="text-align:right">
            <div class="label">Total</div>
            <div style="font-weight:600">Rp {{ number_format($tagihan->total_amount,0,',','.') }}</div>
        </div>
    </div>

    @foreach($tagihan->payments as $pay)
    <div class="payment-row">
        <span style="color:#718096;font-size:.8rem;min-width:90px">{{ \Carbon\Carbon::parse($pay->payment_date)->format('d/m/Y') }}</span>
        <span class="payment-method">{{ $pay->payment_method }}</span>
        <span style="font-weight:600">Rp {{ number_format($pay->amount,0,',','.') }}</span>
        @if($pay->reference_number)
            <span style="font-size:.78rem;color:#a0aec0">Ref: {{ $pay->reference_number }}</span>
        @endif
    </div>
    @endforeach

    @if($tagihan->status !== 'lunas')
        <div class="section-title" style="margin-top:1.25rem">Input Pembayaran Baru</div>
        <form method="POST" action="{{ route('tagihan.payment', $tagihan) }}">
            @csrf
            <div class="pay-form">
                <div class="fg">
                    <label>Jumlah (Rp) *</label>
                    <input type="number" name="amount" value="{{ $sisa }}" min="1" step="500" required>
                </div>
                <div class="fg">
                    <label>Metode *</label>
                    <select name="payment_method" required>
                        @foreach(['tunai','debit','kredit','transfer','qris','bpjs','asuransi'] as $m)
                            <option value="{{ $m }}">{{ ucfirst($m) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fg">
                    <label>Tanggal *</label>
                    <input type="date" name="payment_date" value="{{ today()->format('Y-m-d') }}" required>
                </div>
                <div class="fg">
                    <label>No. Referensi</label>
                    <input type="text" name="reference_number" placeholder="Opsional">
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;margin-top:.75rem">
                <button type="submit" class="btn btn-success">💳 Terima Pembayaran</button>
            </div>
        </form>
    @endif
</div>
@endsection
