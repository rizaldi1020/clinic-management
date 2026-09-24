@extends('layouts.app')

@section('title', 'Edit Janji Temu')
@section('page-title', 'Edit Janji Temu')
@section('breadcrumb', 'Admin / Janji Temu / Edit')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li><a href="{{ route('appointment.index') }}" class="active"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('rekam-medis.index') }}"><span class="menu-icon">🩺</span> Rekam Medis</a></li>
    <li><a href="{{ route('tagihan.index') }}"><span class="menu-icon">💰</span> Pembayaran</a></li>
    
    <li class="menu-label">Master Data</li>
    <li><a href="{{ route('user.index') }}"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="{{ route('departemen.index') }}"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-weight: 500; margin-bottom: .5rem; color: #4a5568; }
    .form-control { width: 100%; padding: .65rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: .875rem; font-family: inherit; transition: all .2s; }
    .form-control:focus { border-color: #1a6db5; outline: none; box-shadow: 0 0 0 3px rgba(26,109,181,.1); }
    .text-danger { color: #e53e3e; font-size: .75rem; margin-top: .25rem; display: block; }
    
    .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.25rem; border-radius: 8px; font-size: .875rem; font-family: inherit; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: background .15s; }
    .btn-primary { background: #1a6db5; color: #fff; }
    .btn-primary:hover { background: #155d9e; }
    .btn-secondary { background: #edf2f7; color: #4a5568; }
    .btn-secondary:hover { background: #e2e8f0; }
    .form-actions { display: flex; gap: .75rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; }
</style>
<!-- Select2 CSS for searchable dropdowns -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="card" style="max-width: 600px;">
    @if($errors->any())
        <div style="padding:1rem; margin-bottom:1rem; background:#fed7d7; color:#9b2c2c; border-radius:8px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('appointment.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Pasien</label>
            <select name="patient_id" id="patient_id" class="form-control select2" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                        {{ $patient->no_rm }} - {{ $patient->name }}
                    </option>
                @endforeach
            </select>
            @error('patient_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Poli / Departemen</label>
            <select name="department_id" id="department_id" class="form-control" required>
                <option value="">-- Pilih Poli --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id', $appointment->department_id) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Dokter</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required disabled>
                <option value="">-- Pilih Dokter --</option>
                <!-- Opsi dokter dimuat via Ajax -->
            </select>
            @error('doctor_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                @error('appointment_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Waktu</label>
                <input type="time" name="appointment_time" class="form-control" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required>
                @error('appointment_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Keluhan Awal</label>
            <textarea name="complaint" class="form-control" rows="3">{{ old('complaint', $appointment->complaint) }}</textarea>
            @error('complaint') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Janji Temu</button>
            <a href="{{ route('appointment.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });

        function loadDoctors(deptId, preselectedDocId) {
            var doctorSelect = $('#doctor_id');
            doctorSelect.empty().append('<option value="">-- Pilih Dokter --</option>');
            doctorSelect.prop('disabled', true);

            if (deptId) {
                $.get('/api/department/' + deptId + '/doctors', function(data) {
                    $.each(data, function(index, doctor) {
                        var selected = preselectedDocId == doctor.id ? 'selected' : '';
                        doctorSelect.append('<option value="' + doctor.id + '" ' + selected + ' >dr. ' + doctor.name + '</option>');
                    });
                    doctorSelect.prop('disabled', false);
                });
            }
        }

        $('#department_id').change(function() {
            loadDoctors($(this).val(), null);
        });

        // Trigger on load for existing data
        if ($('#department_id').val()) {
            loadDoctors($('#department_id').val(), "{{ old('doctor_id', $appointment->doctor_id) }}");
        }
    });
</script>
@endpush
