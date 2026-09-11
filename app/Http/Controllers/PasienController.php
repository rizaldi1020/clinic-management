<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('no_rm', 'like', "%{$search}%")
                  ->orWhere('nik',   'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(15)->withQueryString();

        return view('pasien.index', compact('patients'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm'       => 'required|string|max:20|unique:patients,no_rm',
            'nik'         => 'required|digits:16|unique:patients,nik',
            'name'        => 'required|string|max:150',
            'gender'      => 'required|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date'  => 'required|date|before:today',
            'blood_type'  => 'nullable|in:A,B,AB,O,-',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'allergy'     => 'nullable|string',
        ], [
            'no_rm.unique'   => 'Nomor RM sudah terdaftar.',
            'nik.unique'     => 'NIK sudah terdaftar.',
            'nik.digits'     => 'NIK harus 16 digit angka.',
            'birth_date.before' => 'Tanggal lahir tidak valid.',
        ]);

        Patient::create($validated);

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Patient $pasien)
    {
        $pasien->load(['appointments.doctor.user', 'medicalRecords.doctor.user']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Patient $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Patient $pasien)
    {
        $validated = $request->validate([
            'no_rm'       => ['required','string','max:20', Rule::unique('patients','no_rm')->ignore($pasien->id)],
            'nik'         => ['required','digits:16',        Rule::unique('patients','nik')->ignore($pasien->id)],
            'name'        => 'required|string|max:150',
            'gender'      => 'required|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date'  => 'required|date|before:today',
            'blood_type'  => 'nullable|in:A,B,AB,O,-',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'allergy'     => 'nullable|string',
        ], [
            'no_rm.unique' => 'Nomor RM sudah dipakai pasien lain.',
            'nik.unique'   => 'NIK sudah dipakai pasien lain.',
            'nik.digits'   => 'NIK harus 16 digit angka.',
        ]);

        $pasien->update($validated);

        return redirect()->route('pasien.show', $pasien)
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
