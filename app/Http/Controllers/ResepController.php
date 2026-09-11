<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function create(Request $request)
    {
        $rekamMedis = MedicalRecord::with(['patient', 'doctor.user', 'appointment.department'])
            ->findOrFail($request->rekam_medis_id);

        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();

        return view('resep.create', compact('rekamMedis', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medical_record_id'     => 'required|exists:medical_records,id',
            'prescription_date'     => 'required|date',
            'notes'                 => 'nullable|string',
            'items'                 => 'required|array|min:1',
            'items.*.medicine_id'   => 'required|exists:medicines,id',
            'items.*.dosage'        => 'required|string|max:100',
            'items.*.quantity'      => 'required|integer|min:1',
            'items.*.instructions'  => 'nullable|string',
        ], [
            'items.required'                => 'Tambahkan minimal 1 obat ke resep.',
            'items.*.medicine_id.required'  => 'Pilih obat.',
            'items.*.dosage.required'       => 'Isi dosis obat.',
            'items.*.quantity.min'          => 'Jumlah minimal 1.',
        ]);

        $rekamMedis = MedicalRecord::findOrFail($request->medical_record_id);

        DB::transaction(function () use ($request, $rekamMedis) {
            $resep = Prescription::create([
                'medical_record_id' => $rekamMedis->id,
                'patient_id'        => $rekamMedis->patient_id,
                'doctor_id'         => $rekamMedis->doctor_id,
                'prescription_date' => $request->prescription_date,
                'notes'             => $request->notes,
            ]);

            foreach ($request->items as $item) {
                PrescriptionDetail::create([
                    'prescription_id' => $resep->id,
                    'medicine_id'     => $item['medicine_id'],
                    'dosage'          => $item['dosage'],
                    'quantity'        => $item['quantity'],
                    'instructions'    => $item['instructions'] ?? null,
                ]);

                // Kurangi stok otomatis
                Medicine::find($item['medicine_id'])->decrement('stock', $item['quantity']);
            }
        });

        return redirect()->route('rekam-medis.show', $rekamMedis)
            ->with('success', 'Resep berhasil disimpan. Stok obat otomatis dikurangi.');
    }

    public function show(Prescription $resep)
    {
        $resep->load(['patient', 'doctor.user', 'medicalRecord.appointment.department', 'details.medicine']);
        return view('resep.show', compact('resep'));
    }

    public function destroy(Prescription $resep)
    {
        DB::transaction(function () use ($resep) {
            // Kembalikan stok obat
            foreach ($resep->details as $det) {
                Medicine::find($det->medicine_id)->increment('stock', $det->quantity);
            }
            $resep->delete();
        });

        return redirect()->route('rekam-medis.show', $resep->medical_record_id)
            ->with('success', 'Resep dihapus. Stok obat dikembalikan.');
    }
}
