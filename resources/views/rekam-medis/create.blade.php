@extends('layouts.app')
@section('title','Buat Rekam Medis')
@section('page-title','Buat Rekam Medis')
@section('breadcrumb','Admin / Rekam Medis / Buat')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
@endsection

@push('styles')
<style>
    .form-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:1rem}
    label{font-size:.875rem;font-weight:500;color:#2d3748}
    .required::after{content:' *';color:#e53e3e}
    input,select,textarea{padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;font-family:inherit;color:#1a202c;outline:none;transition:border-color .2s}
    input:focus,select:focus,textarea:focus{border-color:#1a6db5;box-shadow:0 0 0 3px rgba(26,109,181,.1)}
    .is-invalid{border-color:#fc8181!important}
    .invalid-msg{font-size:.8rem;color:#e53e3e}
    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
    .form-actions{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #e2e8f0}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.6rem 1.25rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}

    /* Info box pasien */
    #patient-info{display:none;background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#276749;margin-top:.4rem}
    #patient-info strong{display:block;font-size:.9rem;margin-bottom:.3rem}
    #patient-info .grid{display:grid;grid-template-columns:1fr 1fr;gap:.25rem .75rem;font-size:.82rem}
    #patient-info .allergy{background:#fff5f5;border:1px solid #feb2b2;border-radius:6px;padding:.35rem .65rem;color:#c53030;margin-top:.4rem;font-size:.82rem}

    .info-box{background:#ebf8ff;border:1px solid #bee3f8;border-radius:8px;padding:.75rem 1rem;font-size:.82rem;color:#2b6cb0;margin-bottom:1rem}
</style>
@endpush

@section('content')
<div class="card" style="max-width:780px">

    @if($appointment)
        <div class="info-box">
            ℹ️ Membuat rekam medis untuk janji temu
            <strong>{{ $appointment->appointment_code }}</strong> —
            {{ $appointment->patient->name }} dengan
            {{ $appointment->doctor->user->name }}
            ({{ $appointment->appointment_date->format('d M Y') }})
        </div>
    @endif

    <form method="POST" action="{{ route('rekam-medis.store') }}">
        @csrf

        <p class="section-title">Pilih Janji Temu</p>
        <div class="form-group">
            <label class="required">Janji Temu (status: Dikonfirmasi & belum ada rekam medis)</label>
            <select name="appointment_id" id="appointment_select"
                class="{{ $errors->has('appointment_id') ? 'is-invalid' : '' }}">
                <option value="">— Pilih Janji Temu —</option>
                @foreach($appointments as $apt)
                    <option value="{{ $apt->id }}"
                        data-name="{{ $apt->patient->name }}"
                        data-rm="{{ $apt->patient->no_rm }}"
                        data-nik="{{ $apt->patient->nik }}"
                        data-phone="{{ $apt->patient->phone ?? '—' }}"
                        data-allergy="{{ $apt->patient->allergy }}"
                        data-doctor="{{ $apt->doctor->user->name }}"
                        data-date="{{ $apt->appointment_date->format('d M Y') }}"
                        {{ old('appointment_id', $appointment?->id) == $apt->id ? 'selected' : '' }}>
                        {{ $apt->appointment_code }} — {{ $apt->patient->name }} — {{ $apt->doctor->user->name }} ({{ $apt->appointment_date->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            @error('appointment_id')<p class="invalid-msg">{{ $message }}</p>@enderror

            <div id="patient-info">
                <strong id="pi-name"></strong>
                <div class="grid">
                    <span>No. RM: <b id="pi-rm"></b></span>
                    <span>NIK: <b id="pi-nik"></b></span>
                    <span>No. HP: <b id="pi-phone"></b></span>
                    <span>Dokter: <b id="pi-doctor"></b></span>
                </div>
                <div id="pi-allergy" class="allergy" style="display:none"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="required">Tanggal Kunjungan</label>
            <input type="date" name="visit_date"
                value="{{ old('visit_date', today()->format('Y-m-d')) }}"
                class="{{ $errors->has('visit_date') ? 'is-invalid' : '' }}">
            @error('visit_date')<p class="invalid-msg">{{ $message }}</p>@enderror
        </div>

        <p class="section-title">Hasil Pemeriksaan</p>

        <div class="form-group">
            <label>Anamnesis (Keluhan & Riwayat)</label>
            <textarea name="anamnesis" rows="3"
                placeholder="Keluhan utama, riwayat penyakit, riwayat pengobatan…">{{ old('anamnesis') }}</textarea>
        </div>

        <div class="form-group">
            <label class="required">Diagnosis</label>
            <textarea name="diagnosis" rows="2"
                placeholder="Diagnosis utama dan diagnosis banding…"
                class="{{ $errors->has('diagnosis') ? 'is-invalid' : '' }}">{{ old('diagnosis') }}</textarea>
            @error('diagnosis')<p class="invalid-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Tindakan / Terapi</label>
            <textarea name="treatment" rows="3"
                placeholder="Tindakan medis yang dilakukan, terapi yang diberikan…">{{ old('treatment') }}</textarea>
        </div>

        <div class="form-group">
            <label>Catatan Tambahan</label>
            <textarea name="notes" rows="2"
                placeholder="Catatan dokter, saran, kontrol ulang…">{{ old('notes') }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Rekam Medis</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const sel = document.getElementById('appointment_select');
const box = document.getElementById('patient-info');

function showPatientInfo() {
    const opt = sel.selectedOptions[0];
    if (!opt || !opt.value) { box.style.display = 'none'; return; }

    document.getElementById('pi-name').textContent   = opt.dataset.name;
    document.getElementById('pi-rm').textContent     = opt.dataset.rm;
    document.getElementById('pi-nik').textContent    = opt.dataset.nik;
    document.getElementById('pi-phone').textContent  = opt.dataset.phone;
    document.getElementById('pi-doctor').textContent = opt.dataset.doctor;

    const allergyEl = document.getElementById('pi-allergy');
    if (opt.dataset.allergy) {
        allergyEl.textContent = '⚠️ Alergi: ' + opt.dataset.allergy;
        allergyEl.style.display = 'block';
    } else {
        allergyEl.style.display = 'none';
    }

    box.style.display = 'block';
}

sel.addEventListener('change', showPatientInfo);
if (sel.value) showPatientInfo(); // init
</script>
@endpush
