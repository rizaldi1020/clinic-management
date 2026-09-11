<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles
        $roles = [
            ['name' => 'admin',        'description' => 'Administrator sistem'],
            ['name' => 'dokter',       'description' => 'Tenaga medis / dokter'],
            ['name' => 'resepsionis',  'description' => 'Pendaftaran pasien'],
            ['name' => 'apoteker',     'description' => 'Pengelola obat & resep'],
            ['name' => 'kasir',        'description' => 'Pengelola pembayaran'],
            ['name' => 'pasien',       'description' => 'Akun pasien'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        // User default per role
        $users = [
            [
                'role'    => 'admin',
                'name'    => 'Administrator',
                'email'   => 'admin@klinik.com',
                'password'=> 'password',
                'phone'   => '081200000001',
            ],
            [
                'role'    => 'dokter',
                'name'    => 'Dr. Budi Santoso',
                'email'   => 'dokter@klinik.com',
                'password'=> 'password',
                'phone'   => '081200000002',
            ],
            [
                'role'    => 'resepsionis',
                'name'    => 'Siti Rahayu',
                'email'   => 'resepsionis@klinik.com',
                'password'=> 'password',
                'phone'   => '081200000003',
            ],
            [
                'role'    => 'apoteker',
                'name'    => 'Ahmad Fauzi',
                'email'   => 'apoteker@klinik.com',
                'password'=> 'password',
                'phone'   => '081200000004',
            ],
            [
                'role'    => 'kasir',
                'name'    => 'Dewi Lestari',
                'email'   => 'kasir@klinik.com',
                'password'=> 'password',
                'phone'   => '081200000005',
            ],
        ];

        foreach ($users as $data) {
            $role = Role::where('name', $data['role'])->first();
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'role_id'  => $role->id,
                    'name'     => $data['name'],
                    'password' => Hash::make($data['password']),
                    'phone'    => $data['phone'],
                    'is_active'=> true,
                ]
            );
        }
    }
}
