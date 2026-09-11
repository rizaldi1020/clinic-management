@extends('layouts.app')
@section('title','Buat Tagihan')
@section('page-title','Buat Tagihan')
@section('breadcrumb','Admin / Tagihan / Buat')

@section('sidebar-menu')
    <li class="menu-label">Transaksi</li>
    <li><a href="{{ route('appointment.index') }}"><span class="menu-icon">📅</span> Janji Temu</a></li>
    <li><a href="{{ route('tagihan.index') }}" class="active"><span class="menu-icon">🧾</span> Tagihan</a></li>
@endsection

@push('styles')
<style>
    .form-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:.9rem}
    label{font-size:.875rem;font-weight:500;color:#2d3748}
    .required::after{content:' *';color:#e53e3e}
    input,select,textarea{padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;font-family:inherit;color:#1a202c;outline:none;transition:border-color .2s}
    input:focus,select:focus{border-color:#1a6db5;box-shadow:0 0 0 3px rgba(26,109,181,.1)}
    .is-invalid{border-color:#fc8181!important}
    .invalid-msg{font-size:.8rem;color:#e53e3e}
    .section-title{font-size:.8rem;font-weight:600;color:#718096;text-transform:uppercase;letter-spacing:.07em;margin:1.25rem 0 .75rem;padding-bottom:.5rem;border-bottom:1px solid #e2e8f0}
    .form-actions{display:flex;gap:.75rem;justify-content:flex-end;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #e2e8f0}
    .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.6rem 1.25rem;border-radius:8px;font-size:.875rem;font-family:inherit;font-weight:500;cursor:pointer;border:none;text-decoration:none}
    .btn-primary{background:#1a6db5;color:#fff}.btn-primary:hover{background:#155d9e}
    .btn-secondary{background:#edf2f7;color:#4a5568}.btn-secondary:hover{background:#e2e8f0}
    .btn-danger{background:#fff5f5;color:#c53030;border:1px solid #feb2b2}
    .btn-success{background:#f0fff4;color:#276749;border:1px solid #9ae6b4}
    .btn-sm{padding:.32rem .65rem;font-size:.78rem}

    #patient-info{display:none;background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:.75rem 1rem;font-size:.85rem;color:#276749;margin-top:.4rem;display:grid;grid-template-columns:1fr 1fr;gap:.3rem}

    /* Items table */
    .items-table{width:100%;border-collapse:collapse;font-size:.85rem;margin-bottom:.75rem}
    .items-table th{padding:.55rem .75rem;text-align:left;font-size:.72rem;font-weight:600;color:#718096;text-transform:uppercase;border-bottom:1px solid #e2e8f0}
    .items-table td{padding:.4rem .55rem;vertical-align:top}
    .items-table input{padding:.45rem .65rem;font-size:.835rem}
    .items-table .col-desc{width:40%}
    .items-table .col-qty{width:70px}
    .items-table .col-price{width:140px}
    .items-table .col-sub{width:130px;text-align:right;font-weight:600;padding-top:.75rem;color:#1a202c}
    .items-table .col-aksi{width:44px}

    .total-box{text-align:right;padding:.75rem 1rem;background:#f7fafc;border-radius:8px;font-size:1rem;font-weight:700;color:#1a202c;margin-bottom:.75rem}
    .total-box span{font-size:.82rem;font-weight:400;color:#718096;margin-right:.5rem}
</style>
@endpush

@section('content')
<div class="card" style="max-width:860px">
    <form method="POST" action="{{ route('tagihan.store') }}" id="bill-form">
        @csrf

        <p class="section-title">Pilih Janji Temu</p>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-group">
                <label class="required">Janji Temu (status: Selesai)</label>
                <select name="appointment_id" id="apt_select"
                    class="{{ $errors->has('appointment_id') ? 'is-invalid' : '' }}">
                    <option value="">— Pilih Janji Temu —</option>
                    @foreach($appointments as $apt)
                        <option value="{{ $apt->id }}"
                            data-patient="{{ $apt->patient->name }}"
                            data-rm="{{ $apt->patient->no_rm }}"
                            data-fee="{{ $apt->doctor->consultation_fee }}"
                            data-doctor="{{ $apt->doctor->user->name }}"
                            data-date="{{ $apt->appointment_date->format('Y-m-d') }}"
                            {{ old('appointment_id', $appointment?->id) == $apt->id ? 'selected' : '' }}>
                            {{ $apt->appointment_code }} — {{ $apt->patient->name }} ({{ $apt->appointment_date->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('appointment_id')<p class="invalid-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="required">Tanggal Tagihan</label>
                <input type="date" name="bill_date" value="{{ old('bill_date', today()->format('Y-m-d')) }}">
            </div>
        </div>

        <p class="section-title">Rincian Tagihan</p>
        @error('items')<p style="color:#e53e3e;font-size:.82rem;margin-bottom:.5rem">{{ $message }}</p>@enderror

        <table class="items-table">
            <thead>
                <tr><th class="col-desc">Deskripsi *</th><th class="col-qty">Qty *</th><th class="col-price">Harga Satuan *</th><th class="col-sub">Subtotal</th><th class="col-aksi"></th></tr>
            </thead>
            <tbody id="items-body"></tbody>
        </table>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <button type="button" onclick="addRow()" class="btn btn-success btn-sm">+ Tambah Item</button>
            <div class="total-box"><span>Total:</span> Rp <span id="grand-total">0</span></div>
        </div>

        <div class="form-actions">
            <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">🧾 Buat Tagihan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let rowIdx = 0;

function addRow(desc='', qty=1, price=0) {
    const tbody = document.getElementById('items-body');
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.innerHTML = `
        <td><input type="text" name="items[${rowIdx}][description]" value="${desc}" placeholder="Jasa konsultasi, obat, tindakan…" style="width:100%"></td>
        <td><input type="number" name="items[${rowIdx}][qty]" value="${qty}" min="1" style="width:100%" oninput="recalc(this)"></td>
        <td><input type="number" name="items[${rowIdx}][price]" value="${price}" min="0" step="500" style="width:100%" oninput="recalc(this)"></td>
        <td class="col-sub" id="sub-${rowIdx}">Rp 0</td>
        <td><button type="button" onclick="removeRow(this)" class="btn btn-danger btn-sm" style="padding:.3rem .5rem">✕</button></td>
    `;
    tbody.appendChild(tr);
    recalcAll();
    rowIdx++;
}

function removeRow(btn) {
    if (document.querySelectorAll('.item-row').length === 1) { alert('Minimal 1 item tagihan.'); return; }
    btn.closest('tr').remove();
    recalcAll();
}

function recalc(input) { recalcAll(); }

function recalcAll() {
    let grand = 0;
    document.querySelectorAll('.item-row').forEach((tr, i) => {
        const qty   = parseFloat(tr.querySelector('[name*="[qty]"]').value) || 0;
        const price = parseFloat(tr.querySelector('[name*="[price]"]').value) || 0;
        const sub   = qty * price;
        grand += sub;
        const subEl = tr.querySelector('[id^="sub-"]');
        if (subEl) subEl.textContent = 'Rp ' + sub.toLocaleString('id-ID');
    });
    document.getElementById('grand-total').textContent = grand.toLocaleString('id-ID');
}

// Auto-fill dari janji temu yang dipilih
document.getElementById('apt_select').addEventListener('change', function() {
    const opt = this.selectedOptions[0];
    if (!opt || !opt.value) return;

    // Bersihkan tabel dulu
    document.getElementById('items-body').innerHTML = '';
    rowIdx = 0;

    // Tambah baris biaya konsultasi otomatis
    addRow('Biaya Konsultasi — ' + opt.dataset.doctor, 1, parseFloat(opt.dataset.fee) || 0);
});

// Init: tambah 1 baris kosong
@if($appointment)
    addRow('Biaya Konsultasi — {{ $appointment->doctor->user->name }}', 1, {{ $appointment->doctor->consultation_fee }});
@else
    addRow();
@endif
</script>
@endpush
