<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with(['user', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        $doctors     = $query->latest()->paginate(15)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('dokter.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('dokter.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Data user
            'name'             => 'required|string|max:150',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',
            'phone'            => 'nullable|string|max:20',
            // Data dokter
            'department_id'    => 'required|exists:departments,id',
            'license_number'   => 'required|string|max:50|unique:doctors,license_number',
            'specialization'   => 'nullable|string|max:100',
            'consultation_fee' => 'required|numeric|min:0',
        ], [
            'email.unique'          => 'Email sudah terdaftar.',
            'license_number.unique' => 'Nomor STR/SIP sudah terdaftar.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 8 karakter.',
        ]);

        DB::transaction(function () use ($request) {
            $roleId = Role::where('name', 'dokter')->value('id');

            $user = User::create([
                'role_id'  => $roleId,
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'is_active'=> true,
            ]);

            Doctor::create([
                'user_id'          => $user->id,
                'department_id'    => $request->department_id,
                'license_number'   => $request->license_number,
                'specialization'   => $request->specialization,
                'consultation_fee' => $request->consultation_fee,
            ]);
        });

        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function show(Doctor $dokter)
    {
        $dokter->load(['user', 'department', 'schedules', 'appointments.patient']);
        return view('dokter.show', compact('dokter'));
    }

    public function edit(Doctor $dokter)
    {
        $dokter->load('user');
        $departments = Department::orderBy('name')->get();
        return view('dokter.edit', compact('dokter', 'departments'));
    }

    public function update(Request $request, Doctor $dokter)
    {
        $request->validate([
            'name'             => 'required|string|max:150',
            'email'            => ['required','email', Rule::unique('users','email')->ignore($dokter->user_id)],
            'password'         => 'nullable|string|min:8|confirmed',
            'phone'            => 'nullable|string|max:20',
            'department_id'    => 'required|exists:departments,id',
            'license_number'   => ['required','string','max:50', Rule::unique('doctors','license_number')->ignore($dokter->id)],
            'specialization'   => 'nullable|string|max:100',
            'consultation_fee' => 'required|numeric|min:0',
        ], [
            'email.unique'          => 'Email sudah dipakai user lain.',
            'license_number.unique' => 'Nomor STR/SIP sudah terdaftar.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        DB::transaction(function () use ($request, $dokter) {
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $dokter->user->update($userData);

            $dokter->update([
                'department_id'    => $request->department_id,
                'license_number'   => $request->license_number,
                'specialization'   => $request->specialization,
                'consultation_fee' => $request->consultation_fee,
            ]);
        });

        return redirect()->route('dokter.show', $dokter)
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $dokter)
    {
        DB::transaction(function () use ($dokter) {
            $userId = $dokter->user_id;
            $dokter->delete();
            User::destroy($userId);
        });

        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}
