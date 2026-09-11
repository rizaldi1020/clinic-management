@extends('layouts.app')

@section('title', 'Detail Dokter')
@section('page-title', 'Detail Dokter')
@section('breadcrumb', 'Admin / Dokter / Detail')

@section('sidebar-menu')
    <li class="menu-label">Menu Utama</li>
    <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">🏠</span> Dashboard</a></li>
    <li class="menu-label">Master Data</li>
    <li><a href="#"><span class="menu-icon">👥</span> Manajemen User</a></li>
    <li><a href="#"><span class="menu-icon">🏥</span> Poli / Departemen</a></li>
    <li><a href="{{ route('dokter.index') }}" class="active"><span class="menu-icon">👨‍⚕️</span> Data Dokter</a></li>
    <li><a href="{{ route('pasien.index') }}"><span class="menu-icon">🧑‍🦽</span> Data Pasien</a></li>
    <li><a href="#"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .profile-header { display:flex; align-items:center; gap:1.25rem; padding-bottom:1.25rem; margin-bottom:1.25rem; border-bottom:1px solid #e2e8f0; }
    .avatar { width:64px; height:64px; border-radius:16px; background:linear-gradient(135deg,#1a6db5,#2389d8); display:flex; align-items:center; justify-content:center; font-size:1.75rem; font-weight:700; color:#fff; flex-shrink:0; }
    .profile-header h3 { font-size:1.15rem; font-weight:700; color:#1a202c; margin-bottom:.2rem; }
    .profile-header p { font-size:.875rem; color:#718096; }
    .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .detail-item label { display:block; font-size:.75rem; font-weight:600; color:#a0aec0; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.25rem; }
    .detail-item p { font-size:.9rem; color:#2d3748; }
    .badge { display:inline-block; padding:.2rem .6rem; border-radius:20px; font-size:.78rem; font-weight:600; }
    .badge-teal { background:#e6fffa; color:#276749; }
    .section-title { font-size:.8rem; font-weight:600; color:#718096; text-transform:uppercase; letter-spacing:.07em; margin:1.5rem 0 .75rem; padding-bottom:.5rem; border-bottom:1px solid #e2e8f0; }
    .actions { display:flex; gap:.6rem; margin-bottom:1rem; }
    .btn { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1rem; border-radius:8px; font-size:.875rem; font-family:inherit; font-weight:500; cursor:pointer; border:none; text-decoration:none; }
    .btn-primary   { background:#1a6db5; color:#fff; }
    .btn-primary:hover { background:#155d9e; }
    .btn-secondary { background:#edf2f7; color:#4a5568; }
    .btn-secondary:hover { background:#e2e8f0; }
    .btn-danger    { background:#fff5f5; color:#c53030; border:1px solid #feb2b2; }
    .btn-danger:hover { background:#fee2e2; }
    .btn-sm { padding:.35rem .7rem; font-size:.8rem; }
    .btn-success { background:#f0fff4; color:#276749; border:1px solid #9ae6b4; }
    .btn-success:hover { background:#c6f6d5; }

    /* Jadwal Grid */
    .schedule-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:.75rem; margin-bottom:1rem; }
    .hari-card {
        border:1.5px solid #e2e8f0; border-radius:10px; padding:.85rem;
        position:relative; font-size:.85rem;
    }
    .hari-card.has-schedule { border-color:#bee3f8; background:#ebf8ff; }
    .hari-card .hari-name { font-weight:700; color:#2d3748; margin-bottom:.35rem; text-transform:capitalize; }
    .hari-card .hari-time { color:#4a5568; font-size:.82rem; }
    .hari-card .hari-quota { color:#718096; font-size:.78rem; margin-top:.2rem; }
    .hari-card .hari-actions { display:flex; gap:.3rem; margin-top:.5rem; }
    .hari-card.empty .hari-name { color:#a0aec0; }
    .hari-card.empty p { color:#cbd5e0; font-size:.8rem; margin-top:.25rem; }

    /* Modal */
    .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:200; align-items:center; justify-content:center; }
    .modal-backdrop.open { display:flex; }
    .modal { background:#fff; border-radius:14px; padding:1.5rem; width:100%; max-width:400px; }
    .modal h3 { font-size:1rem; font-weight:700; margin-bottom:1rem; color:#1a202c; }
    .modal .form-group { margin-bottom:.85rem; }
    .modal label { display:block; font-size:.82rem; font-weight:500; color:#4a5568; margin-bottom:.3rem; }
    .modal input { width:100%; padding:.55rem .8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:.875rem; font-family:inherit; outline:none; }
    .modal input:focus { border-color:#1a6db5; }
    .modal .modal-actions { display:flex; justify-content:flex-end; gap:.6rem; margin-top:1rem; }
</style>
@endpush

@section('content')

<div class="actions">
    <a href="{{ route('dokter.index') }}" class="btn btn-secondary">← Kembali</a>
    <a href="{{ route('dokter.edit', $dokter) }}" class="btn btn-primary">✏️ Edit</a>
    <form method="POST" action="{{ route('dokter.destroy', $dokter) }}"
          onsubmit="return confirm('Hapus dr. {{ $dokter->user->name }}? Akun login dokter ini juga ikut terhapus.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
    </form>
</div>

<div class="card">
    {{-- Profil --}}
    <div class="profile-header">
        <div class="avatar">{{ strtoupper(substr($dokter->user->name, 0, 1)) }}</div>
        <div>
            <h3>{{ $dokter->user->name }}</h3>
            <p>
                <span class="badge badge-teal">{{ $dokter->department->name }}</span>
                &nbsp; {{ $dokter->specialization ?? 'Umum' }}
            </p>
        </div>
    </div>

    <div class="detail-grid">
        <div class="detail-item">
            <label>No. STR / SIP</label>
            <p>{{ $dokter->license_number }}</p>
        </div>
        <div class="detail-item">
            <label>Biaya Konsultasi</label>
            <p>Rp {{ number_format($dokter->consultation_fee, 0, ',', '.') }}</p>
        </div>
        <div class="detail-item">
            <label>Email</label>
            <p>{{ $dokter->user->email }}</p>
        </div>
        <div class="detail-item">
            <label>No. HP</label>
            <p>{{ $dokter->user->phone ?? '—' }}</p>
        </div>
    </div>

    {{-- Jadwal Praktik --}}
    <p class="section-title">Jadwal Praktik</p>

    @php
        $hariList   = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];
        $jadwalMap  = $dokter->schedules->keyBy('day_of_week');
    @endphp

    <div class="schedule-grid">
        @foreach($hariList as $hari)
            @if($jadwalMap->has($hari))
                @php $j = $jadwalMap[$hari]; @endphp
                <div class="hari-card has-schedule">
                    <div class="hari-name">{{ ucfirst($hari) }}</div>
                    <div class="hari-time">🕐 {{ substr($j->start_time,0,5) }} – {{ substr($j->end_time,0,5) }}</div>
                    <div class="hari-quota">👥 Kuota: {{ $j->quota }} pasien</div>
                    <div class="hari-actions">
                        <button onclick="openEditModal('{{ $j->id }}','{{ $hari }}','{{ substr($j->start_time,0,5) }}','{{ substr($j->end_time,0,5) }}','{{ $j->quota }}')"
                            class="btn btn-secondary btn-sm">✏️</button>
                        <form method="POST" action="{{ route('jadwal.destroy', [$dokter, $j]) }}"
                              onsubmit="return confirm('Hapus jadwal {{ ucfirst($hari) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="hari-card empty">
                    <div class="hari-name">{{ ucfirst($hari) }}</div>
                    <p>Belum ada jadwal</p>
                    <button onclick="openAddModal('{{ $hari }}')" class="btn btn-success btn-sm" style="margin-top:.5rem">+ Tambah</button>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Riwayat Appointment --}}
    <p class="section-title">Janji Temu Terakhir ({{ $dokter->appointments->count() }})</p>
    @if($dokter->appointments->isEmpty())
        <p style="color:#a0aec0;font-size:.875rem;">Belum ada janji temu.</p>
    @else
        <table style="width:100%;border-collapse:collapse;font-size:.85rem;">
            <thead>
                <tr>
                    <th style="padding:.6rem 1rem;text-align:left;font-size:.75rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">Tanggal</th>
                    <th style="padding:.6rem 1rem;text-align:left;font-size:.75rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">Pasien</th>
                    <th style="padding:.6rem 1rem;text-align:left;font-size:.75rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dokter->appointments->take(10) as $apt)
                <tr>
                    <td style="padding:.6rem 1rem;border-bottom:1px solid #f7fafc;">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }} {{ substr($apt->appointment_time,0,5) }}</td>
                    <td style="padding:.6rem 1rem;border-bottom:1px solid #f7fafc;">{{ $apt->patient->name ?? '—' }}</td>
                    <td style="padding:.6rem 1rem;border-bottom:1px solid #f7fafc;">{{ ucfirst($apt->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Modal Tambah Jadwal --}}
<div class="modal-backdrop" id="modalAdd">
    <div class="modal">
        <h3>Tambah Jadwal Praktik</h3>
        <form method="POST" action="{{ route('jadwal.store', $dokter) }}">
            @csrf
            <input type="hidden" name="day_of_week" id="addHari">
            <div class="form-group">
                <label>Hari</label>
                <input type="text" id="addHariLabel" readonly style="background:#f7fafc;text-transform:capitalize;">
            </div>
            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="start_time" required>
            </div>
            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="end_time" required>
            </div>
            <div class="form-group">
                <label>Kuota Pasien</label>
                <input type="number" name="quota" value="20" min="1" max="100">
            </div>
            <div class="modal-actions">
                <button type="button" onclick="closeModal('modalAdd')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Jadwal --}}
<div class="modal-backdrop" id="modalEdit">
    <div class="modal">
        <h3>Edit Jadwal Praktik</h3>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Hari</label>
                <input type="text" id="editHariLabel" readonly style="background:#f7fafc;text-transform:capitalize;">
            </div>
            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="start_time" id="editStart" required>
            </div>
            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="end_time" id="editEnd" required>
            </div>
            <div class="form-group">
                <label>Kuota Pasien</label>
                <input type="number" name="quota" id="editQuota" min="1" max="100">
            </div>
            <div class="modal-actions">
                <button type="button" onclick="closeModal('modalEdit')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal(hari) {
    document.getElementById('addHari').value = hari;
    document.getElementById('addHariLabel').value = hari;
    document.getElementById('modalAdd').classList.add('open');
}
function openEditModal(id, hari, start, end, quota) {
    const base = '{{ url("dokter/" . $dokter->id . "/jadwal") }}';
    document.getElementById('editForm').action = base + '/' + id;
    document.getElementById('editHariLabel').value = hari;
    document.getElementById('editStart').value = start;
    document.getElementById('editEnd').value = end;
    document.getElementById('editQuota').value = quota;
    document.getElementById('modalEdit').classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}
// Tutup modal jika klik backdrop
document.querySelectorAll('.modal-backdrop').forEach(el => {
    el.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});
</script>
@endpush

@endsection
