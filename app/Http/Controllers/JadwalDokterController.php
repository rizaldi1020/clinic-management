<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function store(Request $request, Doctor $dokter)
    {
        $request->validate([
            'day_of_week' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'quota'       => 'required|integer|min:1|max:100',
        ], [
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        // Cegah duplikasi hari yang sama untuk dokter yang sama
        $exists = $dokter->schedules()
            ->where('day_of_week', $request->day_of_week)
            ->exists();

        if ($exists) {
            return back()->withErrors(['day_of_week' => 'Jadwal hari ' . ucfirst($request->day_of_week) . ' sudah ada.'])->withInput();
        }

        $dokter->schedules()->create($request->only('day_of_week', 'start_time', 'end_time', 'quota'));

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Doctor $dokter, DoctorSchedule $jadwal)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'quota'      => 'required|integer|min:1|max:100',
        ]);

        $jadwal->update($request->only('start_time', 'end_time', 'quota'));

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Doctor $dokter, DoctorSchedule $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
