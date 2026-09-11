@extends('layouts.app')
@section('title','Detail Rekam Medis')
@section('page-title','Detail Rekam Medis')
@section('breadcrumb','Admin / Rekam Medis / Detail')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="#"><span class="menu-icon">💊</span> Resep Obat</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
@endsection

@push('styles')
<style>
    .actions{display:flex;gap:.6rem;margin-bottom:1rem;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}.btn-danger:hover{background:#fee2e2}
    .btn-success{background:#f0fff4;color:#276749;border:1px solid #9ae6b4}.btn-success:hover{background:#c6f6d5}

    /* Header kartu rekam medis */
    .rm-header{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
    .rm-card{border:1.5px solid #e2e8f0;border-radius:10px;padding:1rem}
    .rm-card h4{font-size:.73rem;font-weight:600;color:#a0aec0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem}
    .rm-row{display:flex;gap:.5rem;margin-bottom:.4rem;font-size:.875rem;align-items:baseline}
    .rm-row label{color:#718096;min-width:110px;flex-shrink:0;font-size:.82rem}
    .rm-row span{color:#1a202c;font-weight:500}
    .allergy-tag{background:#fff5f5;border:1px solid #feb2b2;border-radius:6px;padding:.2rem .55rem;color:#c53030;font-size:.8rem;display:inline-block}

    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
    .field-box{background:#f7fafc;border-radius:8px;padding:.85rem 1rem;font-size:.875rem;color:#2d3748;line-height:1.7;white-space:pre-wrap;min-height:48px}
    .field-empty{color:#a0aec0;font-style:italic}

    /* Resep */
    .rx-card{border:1.5px solid #e9d8fd;background:#faf5ff;border-radius:10px;padding:1rem;margin-bottom:.75rem}
    .rx-card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:.6rem}
    .rx-card-header strong{font-size:.875rem;color:#553c9a}
    .rx-table{width:100%;border-collapse:collapse;font-size:.82rem}
    .rx-table th{padding:.5rem .75rem;text-align:left;font-size:.72rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e9d8fd}
    .rx-table td{padding:.5rem .75rem;border-bottom:1px solid #f3e8ff;color:#2d3748}
    .rx-table tr:last-child td{border-bottom:none}
    .rx-notes{font-size:.8rem;color:#718096;margin-top:.4rem}
</style>
@endpush

@section('content')

<div class="actions">
    <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('rekam-medis.edit', $rekamMedis) }}" class="btn btn-primary">✏️ Edit</a>
    <a href="{{ route('appointment.show', $rekamMedis->appointment) }}" class="btn btn-secondary">📅 Lihat Janji Temu</a>
    <a href="{{ route('pasien.show', $rekamMedis->patient) }}" class="btn btn-secondary">🧑‍🦽 Profil Pasien</a>
    <form method="POST" action="{{ route('rekam-medis.destroy', $rekamMedis) }}"
          onsubmit="return confirm('Hapus rekam medis ini? Status janji temu akan dikembalikan ke Dikonfirmasi.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
    </form>
</div>

{{-- Header 2 kolom --}}
<div class="rm-header">
    <div class="rm-card">
        <h4>🧑‍🦽 Data Pasien</h4>
        <div class="rm-row"><label>Nama</label><span>{{ $rekamMedis->patient->name }}</span></div>
        <div class="rm-row"><label>No. RM</label><span>{{ $rekamMedis->patient->no_rm }}</span></div>
        <div class="rm-row"><label>NIK</label><span>{{ $rekamMedis->patient->nik }}</span></div>
        <div class="rm-row"><label>JK / Usia</label>
            <span>{{ $rekamMedis->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} / {{ $rekamMedis->patient->birth_date->age }} tahun</span>
        </div>
        <div class="rm-row"><label>Gol. Darah</label><span>{{ $rekamMedis->patient->blood_type ?? '—' }}</span></div>
        @if($rekamMedis->patient->allergy)
        <div class="rm-row"><label>Alergi</label><span><span class="allergy-tag">⚠️ {{ $rekamMedis->patient->allergy }}</span></span></div>
        @endif
    </div>
    <div class="rm-card">
        <h4>👨‍⚕️ Kunjungan</h4>
        <div class="rm-row"><label>Tanggal</label><span>{{ \Carbon\Carbon::parse($rekamMedis->visit_date)->format('d F Y') }}</span></div>
        <div class="rm-row"><label>Dokter</label><span>{{ $rekamMedis->doctor->user->name }}</span></div>
        <div class="rm-row"><label>Poli</label><span>{{ $rekamMedis->appointment->department->name }}</span></div>
        <div class="rm-row"><label>Kode Janji</label><span style="font-family:monospace;font-size:.85rem">{{ $rekamMedis->appointment->appointment_code }}</span></div>
        <div class="rm-row"><label>Dibuat</label><span>{{ $rekamMedis->created_at->format('d/m/Y H:i') }}</span></div>
    </div>
</div>

{{-- Isi rekam medis --}}
<div class="card">
    <div class="section-title">Anamnesis</div>
    <div class="field-box">{{ $rekamMedis->anamnesis ?: '<span class="field-empty">Tidak ada catatan anamnesis.</span>' }}</div>

    <div class="section-title">Diagnosis</div>
    <div class="field-box">{{ $rekamMedis->diagnosis }}</div>

    <div class="section-title">Tindakan / Terapi</div>
    <div class="field-box">{{ $rekamMedis->treatment ?: '<span class="field-empty">Tidak ada catatan tindakan.</span>' }}</div>

    <div class="section-title">Catatan Tambahan</div>
    <div class="field-box">{{ $rekamMedis->notes ?: '<span class="field-empty">Tidak ada catatan tambahan.</span>' }}</div>
</div>

{{-- Resep terkait --}}
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem">
        <div class="section-title" style="margin:0">Resep Obat ({{ $rekamMedis->prescriptions->count() }})</div>
        <a href="#" class="btn btn-success" style="font-size:.82rem">+ Tambah Resep</a>
    </div>

    @if($rekamMedis->prescriptions->isEmpty())
        <p style="color:#a0aec0;font-size:.875rem">Belum ada resep untuk kunjungan ini.</p>
    @else
        @foreach($rekamMedis->prescriptions as $rx)
        <div class="rx-card">
            <div class="rx-card-header">
                <strong>💊 Resep #{{ $loop->iteration }} — {{ \Carbon\Carbon::parse($rx->prescription_date)->format('d M Y') }}</strong>
                <div style="display:flex;gap:.4rem">
                    <a href="#" class="btn btn-secondary" style="font-size:.78rem;padding:.3rem .65rem">✏️ Edit</a>
                </div>
            </div>
            <table class="rx-table">
                <thead>
                    <tr><th>Nama Obat</th><th>Dosis</th><th>Jumlah</th><th>Instruksi</th></tr>
                </thead>
                <tbody>
                    @foreach($rx->details as $det)
                    <tr>
                        <td>{{ $det->medicine->name }}</td>
                        <td>{{ $det->dosage }}</td>
                        <td>{{ $det->quantity }} {{ $det->medicine->unit }}</td>
                        <td>{{ $det->instructions ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($rx->notes)
                <div class="rx-notes">📝 {{ $rx->notes }}</div>
            @endif
        </div>
        @endforeach
    @endif
</div>
@endsection
