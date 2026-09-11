@extends('layouts.app')
@section('title','Buat Resep')
@section('page-title','Buat Resep Obat')
@section('breadcrumb','Admin / Rekam Medis / Resep')

@section('sidebar-menu')
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('rekam-medis.index') }}" class="active"><span class="menu-icon">📋</span> Rekam Medis</a></li>
    <li><a href="{{ route('obat.index') }}"><span class="menu-icon">💊</span> Data Obat</a></li>
@endsection

@push('styles')
<style>
    .rm-info{background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:.85rem 1rem;font-size:.875rem;color:#276749;margin-bottom:1rem;display:grid;grid-template-columns:1fr 1fr;gap:.25rem .75rem}
    .rm-info span{color:#276749;font-size:.78rem}
    .form-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:.85rem}
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
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}
    .btn-sm{padding:.32rem .65rem;font-size:.78rem}
    .btn-success{background:#f0fff4;color:#276749;border:1px solid #9ae6b4}

    /* Tabel item obat */
    .items-table{width:100%;border-collapse:collapse;font-size:.855rem;margin-bottom:.75rem}
    .items-table th{padding:.55rem .75rem;text-align:left;font-size:.72rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0}
    .items-table td{padding:.45rem .6rem;vertical-align:top}
    .items-table select,.items-table input{padding:.45rem .65rem;font-size:.835rem}
    .items-table .col-obat{width:35%}
    .items-table .col-dosis{width:25%}
    .items-table .col-qty{width:80px}
    .items-table .col-instruksi{width:auto}
    .items-table .col-aksi{width:48px}
    .stock-hint{font-size:.72rem;color:#a0aec0;margin-top:.2rem}
</style>
@endpush

@section('content')
<div class="card" style="max-width:900px">

    {{-- Info rekam medis --}}
    <div class="rm-info">
        <div><span>Pasien</span><br><strong>{{ $rekamMedis->patient->name }}</strong> ({{ $rekamMedis->patient->no_rm }})</div>
        <div><span>Dokter</span><br><strong>{{ $rekamMedis->doctor->user->name }}</strong></div>
        <div><span>Tanggal Kunjungan</span><br><strong>{{ \Carbon\Carbon::parse($rekamMedis->visit_date)->format('d M Y') }}</strong></div>
        <div><span>Diagnosis</span><br><strong>{{ Str::limit($rekamMedis->diagnosis, 60) }}</strong></div>
    </div>

    <form method="POST" action="{{ route('resep.store') }}">
        @csrf
        <input type="hidden" name="medical_record_id" value="{{ $rekamMedis->id }}">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label class="required">Tanggal Resep</label>
                <input type="date" name="prescription_date"
                    value="{{ old('prescription_date', today()->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Catatan Resep</label>
                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Misal: diminum sebelum tidur">
            </div>
        </div>

        <p class="section-title">Daftar Obat <span style="font-weight:400;text-transform:none;letter-spacing:0">(minimal 1 obat)</span></p>

        @if($errors->has('items'))
            <p style="color:#e53e3e;font-size:.82rem;margin-bottom:.5rem">{{ $errors->first('items') }}</p>
        @endif

        <table class="items-table">
            <t>
                <tr>
                    <th class="col-obat">Nama Obat *</th>
                    <th class="col-dosis">Dosis *</th>
                    <th class="col-qty">Jml *</th>
                    <th class="col-instruksi">Instruksi</th>
                    <th class="col-aksi"></th>
                </tr>
            </t head>
            <tbody id="items-body">
                <tr class="item-row">
                    <td>
                        <select name="items[0][medicine_id]" class="medicine-select" style="width:100%">
                            <option value="">— Pilih Obat —</option>
                            @foreach($medicines as $m)
                                <option value="{{ $m->id }}" data-stock="{{ $m->stock }}" data-unit="{{ $m->unit }}">
                                    {{ $m->name }} ({{ $m->unit }})
                                </option>
                            @endforeach
                        </select>
                        <div class="stock-hint stock-info">Stok: —</div>
                    </td>
                    <td><input type="text" name="items[0][dosage]" placeholder="3x1 sehari" style="width:100%"></td>
                    <td><input type="number" name="items[0][quantity]" value="1" min="1" style="width:100%"></td>
                    <td><input type="text" name="items[0][instructions]" placeholder="Sesudah makan" style="width:100%"></td>
                    <td><button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm" style="padding:.35rem .55rem">✕</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="addRow()" class="btn btn-success btn-sm">+ Tambah Obat</button>

        <div class="form-actions">
            <a href="{{ route('rekam-medis.show', $rekamMedis) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">💊 Simpan Resep</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Opsi obat untuk cloning
const medicineOptions = `@foreach($medicines as $m)<option value="{{ $m->id }}" data-stock="{{ $m->stock }}" data-unit="{{ $m->unit }}">{{ $m->name }} ({{ $m->unit }})</option>@endforeach`;

let rowIndex = 1;

function addRow() {
    const tbody = document.getElementById('items-body');
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.innerHTML = `
        <td>
            <select name="items[${rowIndex}][medicine_id]" class="medicine-select" style="width:100%" onchange="updateStockHint(this)">
                <option value="">— Pilih Obat —</option>
                ${medicineOptions}
            </select>
            <div class="stock-hint stock-info">Stok: —</div>
        </td>
        <td><input type="text" name="items[${rowIndex}][dosage]" placeholder="3x1 sehari" style="width:100%"></td>
        <td><input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" style="width:100%"></td>
        <td><input type="text" name="items[${rowIndex}][instructions]" placeholder="Sesudah makan" style="width:100%"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm" style="padding:.35rem .55rem">✕</button></td>
    `;
    tbody.appendChild(tr);
    rowIndex++;
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length === 1) { alert('Minimal 1 obat harus ada di resep.'); return; }
    btn.closest('tr').remove();
}

function updateStockHint(sel) {
    const opt = sel.selectedOptions[0];
    const hint = sel.closest('td').querySelector('.stock-info');
    if (!opt || !opt.value) { hint.textContent = 'Stok: —'; return; }
    const stock = opt.dataset.stock;
    hint.textContent = `Stok tersedia: ${stock} ${opt.dataset.unit}`;
    hint.style.color = stock == 0 ? '#c53030' : stock <= 10 ? '#b7791f' : '#a0aec0';
}

// Init listener untuk baris pertama
document.querySelectorAll('.medicine-select').forEach(sel => {
    sel.addEventListener('change', () => updateStockHint(sel));
});
</script>
@endpush
