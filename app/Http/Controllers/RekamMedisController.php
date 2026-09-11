<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor.user', 'appointment']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('no_rm', 'like', "%{$search}%"))
                  ->orWhere('diagnosis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        }

        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }

        $records = $query->latest('visit_date')->paginate(20)->withQueryString();
        $doctors = \App\Models\Doctor::with('user')->get();

        return view('rekam-medis.index', compact('records', 'doctors'));
    }

    public function create(Request $request)
    {
        // Bisa dibuka dari appointment (sudah ada appointment_id di query)
        $appointment = null;
        if ($request->filled('appointment_id')) {
            $appointment = Appointment::with(['patient', 'doctor.user', 'department'])
                ->findOrFail($request->appointment_id);

            // Cegah duplikasi rekam medis untuk appointment yang sama
            if ($appointment->medicalRecord) {
                return redirect()->route('rekam-medis.show', $appointment->medicalRecord)
                    ->with('success', 'Rekam medis untuk janji temu ini sudah ada.');
            }
        }

        $appointments = Appointment::with(['patient', 'doctor.user'])
            ->where('status', 'dikonfirmasi')
            ->whereDoesntHave('medicalRecord')
            ->orderBy('appointment_date')
            ->get();

        return view('rekam-medis.create', compact('appointment', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:medical_records,appointment_id',
            'visit_date'     => 'required|date',
            'anamnesis'      => 'nullable|string',
            'diagnosis'      => 'required|string|max:500',
            'treatment'      => 'nullable|string',
            'notes'          => 'nullable|string',
        ], [
            'appointment_id.unique'   => 'Rekam medis untuk janji temu ini sudah ada.',
            'diagnosis.required'      => 'Diagnosis wajib diisi.',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        $record = MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'patient_id'     => $appointment->patient_id,
            'doctor_id'      => $appointment->doctor_id,
            'visit_date'     => $request->visit_date,
            'anamnesis'      => $request->anamnesis,
            'diagnosis'      => $request->diagnosis,
            'treatment'      => $request->treatment,
            'notes'          => $request->notes,
        ]);

        // Otomatis tandai appointment sebagai selesai
        $appointment->update(['status' => 'selesai']);

        return redirect()->route('rekam-medis.show', $record)
            ->with('success', 'Rekam medis berhasil disimpan. Status janji temu diperbarui ke Selesai.');
    }

    public function show(MedicalRecord $rekamMedis)
    {
        $rekamMedis->load([
            'patient',
            'doctor.user',
            'appointment.department',
            'prescriptions.details.medicine',
        ]);
        return view('rekam-medis.show', compact('rekamMedis'));
    }

    public function edit(MedicalRecord $rekamMedis)
    {
        $rekamMedis->load(['appointment.patient', 'appointment.doctor.user']);
        return view('rekam-medis.edit', compact('rekamMedis'));
    }

    public function update(Request $request, MedicalRecord $rekamMedis)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'anamnesis'  => 'nullable|string',
            'diagnosis'  => 'required|string|max:500',
            'treatment'  => 'nullable|string',
            'notes'      => 'nullable|string',
        ]);

        $rekamMedis->update($request->only('visit_date', 'anamnesis', 'diagnosis', 'treatment', 'notes'));

        return redirect()->route('rekam-medis.show', $rekamMedis)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $rekamMedis)
    {
        // Kembalikan status appointment ke dikonfirmasi
        $rekamMedis->appointment->update(['status' => 'dikonfirmasi']);
        $rekamMedis->delete();

        return redirect()->route('rekam-medis.index')
            ->with('success', 'Rekam medis berhasil dihapus. Status janji temu dikembalikan ke Dikonfirmasi.');
    }
}
