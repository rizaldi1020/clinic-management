<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmed;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor.user', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('appointment_code', 'like', "%{$search}%")
                  ->orWhereHas('patient', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        } else {
            $query->whereDate('appointment_date', '>=', today());
        }

        $appointments = $query->orderBy('appointment_date')->orderBy('appointment_time')->paginate(20)->withQueryString();
        $departments  = Department::orderBy('name')->get();
        $doctors      = Doctor::with('user')->get();

        return view('appointment.index', compact('appointments', 'departments', 'doctors'));
    }

    public function create()
    {
        $patients    = Patient::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $doctors     = Doctor::with(['user', 'department', 'schedules'])->get();

        return view('appointment.create', compact('patients', 'departments', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'department_id'    => 'required|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'complaint'        => 'nullable|string|max:500',
        ], [
            'appointment_date.after_or_equal' => 'Tanggal janji tidak boleh di masa lalu.',
        ]);

        // Cek bentrok jadwal (dokter)
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'dibatalkan')
            ->exists();

        if ($doctorConflict) {
            return back()->withInput()->withErrors(['appointment_time' => 'Dokter sudah memiliki janji pada jam tersebut.']);
        }

        // Cek bentrok jadwal (pasien)
        $patientConflict = Appointment::where('patient_id', $request->patient_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'dibatalkan')
            ->exists();

        if ($patientConflict) {
            return back()->withInput()->withErrors(['appointment_time' => 'Pasien sudah memiliki janji pada jam tersebut.']);
        }

        $code = 'APT-' . strtoupper(Str::random(3)) . '-' . now()->format('dmY');

        $appointment = Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'department_id'    => $request->department_id,
            'appointment_code' => $code,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'complaint'        => $request->complaint,
            'status'           => 'menunggu',
        ]);

        // Kirim email konfirmasi ke pasien (jika punya akun email)
        $appointment->load(['patient.user', 'doctor.user', 'department']);
        $patientEmail = $appointment->patient->user?->email;

        if ($patientEmail) {
            try {
                Mail::to($patientEmail)->send(new AppointmentConfirmed($appointment));
            } catch (\Exception $e) {
                Log::warning('Gagal kirim email konfirmasi appointment: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointment.index')
            ->with('success', "Janji temu berhasil dibuat. Kode: {$code}");
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor.user', 'department', 'medicalRecord', 'bill']);
        return view('appointment.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        if ($appointment->status !== 'menunggu') {
            return back()->withErrors(['edit' => 'Janji temu yang sudah dikonfirmasi/selesai/dibatalkan tidak bisa diedit.']);
        }

        $patients    = Patient::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $doctors     = Doctor::with(['user', 'department', 'schedules'])->get();

        return view('appointment.edit', compact('appointment', 'patients', 'departments', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'menunggu') {
            return back()->withErrors(['edit' => 'Tidak bisa mengubah janji temu ini.']);
        }

        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'department_id'    => 'required|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'complaint'        => 'nullable|string|max:500',
        ]);

        // Cek bentrok jadwal (dokter)
        $doctorConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'dibatalkan')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($doctorConflict) {
            return back()->withInput()->withErrors(['appointment_time' => 'Dokter sudah memiliki janji pada jam tersebut.']);
        }

        // Cek bentrok jadwal (pasien)
        $patientConflict = Appointment::where('patient_id', $request->patient_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->whereTime('appointment_time', $request->appointment_time)
            ->where('status', '!=', 'dibatalkan')
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($patientConflict) {
            return back()->withInput()->withErrors(['appointment_time' => 'Pasien sudah memiliki janji pada jam tersebut.']);
        }

        $appointment->update($request->only(
            'patient_id', 'doctor_id', 'department_id',
            'appointment_date', 'appointment_time', 'complaint'
        ));

        return redirect()->route('appointment.show', $appointment)
            ->with('success', 'Janji temu berhasil diperbarui.');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->status === 'selesai') {
            return back()->withErrors(['delete' => 'Janji temu yang sudah selesai tidak bisa dihapus.']);
        }

        $appointment->delete();

        return redirect()->route('appointment.index')
            ->with('success', 'Janji temu berhasil dihapus.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ]);

        $appointment->update(['status' => $request->status]);

        $label = match ($request->status) {
            'dikonfirmasi' => 'dikonfirmasi',
            'selesai'      => 'ditandai selesai',
            'dibatalkan'   => 'dibatalkan',
            default        => 'diperbarui',
        };

        return back()->with('success', "Status janji temu berhasil {$label}.");
    }

    public function getDoctorsByDepartment(Department $department)
    {
        $doctors = $department->doctors()->with(['user', 'schedules'])->get()
            ->map(fn($d) => [
                'id'        => $d->id,
                'name'      => $d->user->name,
                'fee'       => $d->consultation_fee,
                'schedules' => $d->schedules->pluck('day_of_week'),
            ]);

        return response()->json($doctors);
    }
}
