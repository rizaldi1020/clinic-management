@extends('layouts.app')
@section('title','Detail Resep')
@section('page-title','Detail Resep')
@section('breadcrumb','Admin / Rekam Medis / Resep')

@section('sidebar-menu')
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .actions{display:flex;gap:.6rem;margin-bottom:1rem}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .header-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
    .hcard{border:1.5px solid #e2e8f0;border-radius:10px;padding:1rem}
    .hcard h4{font-size:.73rem;font-weight:600;color:#a0aec0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem}
    .hrow{display:flex;gap:.5rem;margin-bottom:.35rem;font-size:.875rem}
    .hrow label{color:#718096;min-width:110px;flex-shrink:0;font-size:.82rem}
    .hrow span{color:#1a202c;font-weight:500}
    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
    table{width:100%;border-collapse:collapse;font-size:.875rem}
    thead th{padding:.65rem 1rem;text-align:left;font-size:.73rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0}
    tbody td{padding:.7rem 1rem;border-bottom:1px solid #f7fafc;color:#2d3748}
    tbody tr:last-child td{border-bottom:none}
    .total-row{font-weight:700;background:#f7fafc}
</style>
@endpush

@section('content')
<div class="actions">
    <a href="{{ route('rekam-medis.show', $resep->medicalRecord) }}" class="btn btn-secondary">← Kembali ke Rekam Medis</a>
    <form method="POST" action="{{ route('resep.destroy', $resep) }}"
          onsubmit="return confirm('Hapus resep ini? Stok obat akan dikembalikan.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus Resep</button>
    </form>
</div>

<div class="header-grid">
    <div class="hcard">
        <h4>🧑‍🦽 Pasien</h4>
        <div class="hrow"><label>Nama</label><span>{{ $resep->patient->name }}</span></div>
        <div class="hrow"><label>No. RM</label><span>{{ $resep->patient->no_rm }}</span></div>
        <div class="hrow"><label>Diagnosis</label><span>{{ Str::limit($resep->medicalRecord->diagnosis, 60) }}</span></div>
    </div>
    <div class="hcard">
        <h4>👨‍⚕️ Resep</h4>
        <div class="hrow"><label>Dokter</label><span>{{ $resep->doctor->user->name }}</span></div>
        <div class="hrow"><label>Tgl Resep</label><span>{{ \Carbon\Carbon::parse($resep->prescription_date)->format('d M Y') }}</span></div>
        <div class="hrow"><label>Poli</label><span>{{ $resep->medicalRecord->appointment->department->name }}</span></div>
        @if($resep->notes)
        <div class="hrow"><label>Catatan</label><span>{{ $resep->notes }}</span></div>
        @endif
    </div>
</div>

<div class="card">
    <div class="section-title">Daftar Obat</div>
    <table>
        <thead>
            <tr><th>#</th><th>Nama Obat</th><th>Dosis</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th><th>Instruksi</th></tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($resep->details as $i => $det)
            @php $subtotal = $det->quantity * $det->medicine->price; $total += $subtotal; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $det->medicine->name }}</strong></td>
                <td>{{ $det->dosage }}</td>
                <td>{{ $det->quantity }} {{ $det->medicine->unit }}</td>
                <td>Rp {{ number_format($det->medicine->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                <td>{{ $det->instructions ?? '—' }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align:right;padding-right:1rem">Total Biaya Obat:</td>
                <td colspan="2">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
