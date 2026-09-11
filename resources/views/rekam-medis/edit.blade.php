@extends('layouts.app')
@section('title','Edit Rekam Medis')
@section('page-title','Edit Rekam Medis')
@section('breadcrumb','Admin / Rekam Medis / Edit')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
@endsection

@push('styles')
<style>
    .form-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:1rem}
    label{font-size:.875rem;font-weight:500;color:#2d3748}
    .required::after{content:' *';color:#e53e3e}
    input,textarea{padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;font-family:inherit;color:#1a202c;outline:none;transition:border-color .2s}
    input:focus,textarea:focus{border-color:#1a6db5;box-shadow:0 0 0 3px rgba(26,109,181,.1)}
    .is-invalid{border-color:#fc8181!important}
    .invalid-msg{font-size:.8rem;color:#e53e3e}
    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
    .form-actions{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #e2e8f0}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.6rem 1.25rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .apt-info{background:#f7fafc;border:1.5px solid #e2e8f0;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#4a5568;margin-bottom:1rem;display:grid;grid-template-columns:1fr 1fr;gap:.3rem}
    .apt-info span{color:#718096;font-size:.78rem}
</style>
@endpush

@section('content')
<div class="card" style="max-width:780px">

    <div class="apt-info">
        <div><span>Pasien</span><br><strong>{{ $rekamMedis->patient->name }}</strong> ({{ $rekamMedis->patient->no_rm }})</div>
        <div><span>Dokter</span><br><strong>{{ $rekamMedis->doctor->user->name }}</strong></div>
        <div><span>Kode Janji</span><br><strong>{{ $rekamMedis->appointment->appointment_code }}</strong></div>
        <div><span>Poli</span><br><strong>{{ $rekamMedis->appointment->department->name }}</strong></div>
    </div>

    <form method="POST" action="{{ route('rekam-medis.update', $rekamMedis) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="required">Tanggal Kunjungan</label>
            <input type="date" name="visit_date"
                value="{{ old('visit_date', \Carbon\Carbon::parse($rekamMedis->visit_date)->format('Y-m-d')) }}"
                class="{{ $errors->has('visit_date') ? 'is-invalid' : '' }}">
            @error('visit_date')<p class="invalid-msg">{{ $message }}</p>@enderror
        </div>

        <p class="section-title">Hasil Pemeriksaan</p>

        <div class="form-group">
            <label>Anamnesis</label>
            <textarea name="anamnesis" rows="3">{{ old('anamnesis', $rekamMedis->anamnesis) }}</textarea>
        </div>

        <div class="form-group">
            <label class="required">Diagnosis</label>
            <textarea name="diagnosis" rows="2"
                class="{{ $errors->has('diagnosis') ? 'is-invalid' : '' }}">{{ old('diagnosis', $rekamMedis->diagnosis) }}</textarea>
            @error('diagnosis')<p class="invalid-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Tindakan / Terapi</label>
            <textarea name="treatment" rows="3">{{ old('treatment', $rekamMedis->treatment) }}</textarea>
        </div>

        <div class="form-group">
            <label>Catatan Tambahan</label>
            <textarea name="notes" rows="2">{{ old('notes', $rekamMedis->notes) }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('rekam-medis.show', $rekamMedis) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
