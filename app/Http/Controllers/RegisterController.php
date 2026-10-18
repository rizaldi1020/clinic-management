<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('pasien.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            // Data akun
            'name'                  => 'required|string|max:150',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            // Data pasien
            'nik'                   => 'required|digits:16|unique:patients,nik',
            'gender'                => 'required|in:L,P',
            'birth_place'           => 'nullable|string|max:100',
            'birth_date'            => 'required|date|before:today',
            'phone'                 => 'nullable|string|max:20',
            'address'               => 'nullable|string',
            'allergy'               => 'nullable|string',
        ], [
            'nik.unique'            => 'NIK sudah terdaftar.',
            'nik.digits'            => 'NIK harus 16 digit angka.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 8 karakter.',
            'birth_date.before'     => 'Tanggal lahir tidak valid.',
        ]);

        DB::transaction(function () use ($request) {
            $roleId = Role::where('name', 'pasien')->value('id');

            // Generate No. RM otomatis
            $lastRm = Patient::orderByDesc('id')->value('no_rm');
            $lastNo  = $lastRm ? (int) substr($lastRm, 3) : 0;
            $noRm    = 'RM-' . str_pad($lastNo + 1, 5, '0', STR_PAD_LEFT);

            // Buat akun user
            $user = User::create([
                'role_id'   => $roleId,
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'address'   => $request->address,
                'is_active' => true,
            ]);

            // Buat data pasien
            Patient::create([
                'user_id'     => $user->id,
                'no_rm'       => $noRm,
                'nik'         => $request->nik,
                'name'        => $request->name,
                'gender'      => $request->gender,
                'birth_place' => $request->birth_place,
                'birth_date'  => $request->birth_date,
                'blood_type'  => $request->blood_type ?? '-',
                'phone'       => $request->phone,
                'address'     => $request->address,
                'allergy'     => $request->allergy,
            ]);

            // Auto login setelah register
            Auth::login($user);
        });

        return redirect()->route('pasien.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang di Klinik Management.');
    }
}
