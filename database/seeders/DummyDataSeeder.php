<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Role, User, Department, Doctor, DoctorSchedule, Patient, Appointment, MedicalRecord, Medicine, Prescription, PrescriptionDetail, Bill, BillDetail, Payment};

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Departments ──────────────────────────────────────────────────────
        $deptData = [
            ['name' => 'Poli Umum',       'description' => 'Layanan kesehatan umum'],
            ['name' => 'Poli Gigi',        'description' => 'Perawatan gigi dan mulut'],
            ['name' => 'Poli Anak',        'description' => 'Layanan kesehatan anak'],
            ['name' => 'Poli Kandungan',   'description' => 'Layanan kebidanan dan kandungan'],
            ['name' => 'Poli Mata',        'description' => 'Pemeriksaan dan perawatan mata'],
            ['name' => 'Poli THT',         'description' => 'Telinga, hidung, dan tenggorokan'],
        ];
        foreach ($deptData as $d) Department::firstOrCreate(['name' => $d['name']], $d);
        $departments = Department::all();

        // ── 2. Doctors ──────────────────────────────────────────────────────────
        $roleId = Role::where('name','dokter')->value('id');
        $doctorData = [
            ['name'=>'dr. Andi Prasetyo, Sp.U',  'email'=>'andi@klinik.com',  'dept'=>'Poli Umum',     'str'=>'STR-001-2024','spec'=>'Dokter Umum',    'fee'=>100000],
            ['name'=>'drg. Sari Dewi',            'email'=>'sari@klinik.com',  'dept'=>'Poli Gigi',     'str'=>'STR-002-2024','spec'=>'Dokter Gigi',    'fee'=>150000],
            ['name'=>'dr. Bambang, Sp.A',         'email'=>'bambang@klinik.com','dept'=>'Poli Anak',    'str'=>'STR-003-2024','spec'=>'Spesialis Anak', 'fee'=>200000],
            ['name'=>'dr. Rina Wulandari, Sp.OG', 'email'=>'rina@klinik.com',  'dept'=>'Poli Kandungan','str'=>'STR-004-2024','spec'=>'Sp. Kandungan', 'fee'=>250000],
        ];
        foreach ($doctorData as $dd) {
            $user = User::firstOrCreate(['email'=>$dd['email']], [
                'role_id'   => $roleId,
                'name'      => $dd['name'],
                'password'  => Hash::make('password'),
                'phone'     => '0812'.rand(10000000,99999999),
                'is_active' => true,
            ]);
            $dept = $departments->firstWhere('name', $dd['dept']);
            $doc = Doctor::firstOrCreate(['license_number'=>$dd['str']], [
                'user_id'          => $user->id,
                'department_id'    => $dept->id,
                'specialization'   => $dd['spec'],
                'consultation_fee' => $dd['fee'],
            ]);
            // Jadwal
            $days = ['senin','rabu','jumat'];
            foreach ($days as $day) {
                DoctorSchedule::firstOrCreate(['doctor_id'=>$doc->id,'day_of_week'=>$day], [
                    'start_time' => '08:00', 'end_time' => '12:00', 'quota' => 20,
                ]);
            }
        }

        // ── 3. Patients ─────────────────────────────────────────────────────────
        $pasienData = [
            ['no_rm'=>'RM-001','nik'=>'3578010101800001','name'=>'Budi Santoso',     'gender'=>'L','birth_date'=>'1980-01-01','phone'=>'081200001111'],
            ['no_rm'=>'RM-002','nik'=>'3578010101850002','name'=>'Siti Aminah',      'gender'=>'P','birth_date'=>'1985-05-15','phone'=>'081200002222'],
            ['no_rm'=>'RM-003','nik'=>'3578010101900003','name'=>'Ahmad Fauzan',     'gender'=>'L','birth_date'=>'1990-03-20','phone'=>'081200003333'],
            ['no_rm'=>'RM-004','nik'=>'3578010101950004','name'=>'Dewi Rahayu',      'gender'=>'P','birth_date'=>'1995-07-10','phone'=>'081200004444'],
            ['no_rm'=>'RM-005','nik'=>'3578010102000005','name'=>'Rizki Pratama',    'gender'=>'L','birth_date'=>'2000-12-25','phone'=>'081200005555'],
            ['no_rm'=>'RM-006','nik'=>'3578010101750006','name'=>'Sri Wahyuni',      'gender'=>'P','birth_date'=>'1975-08-08','allergy'=>'Penisilin'],
            ['no_rm'=>'RM-007','nik'=>'3578010101880007','name'=>'Hendra Kusuma',    'gender'=>'L','birth_date'=>'1988-11-30'],
            ['no_rm'=>'RM-008','nik'=>'3578010101920008','name'=>'Nurul Hidayah',    'gender'=>'P','birth_date'=>'1992-04-14'],
        ];
        foreach ($pasienData as $p) {
            Patient::firstOrCreate(['nik'=>$p['nik']], [
                'no_rm'      => $p['no_rm'],
                'name'       => $p['name'],
                'gender'     => $p['gender'],
                'birth_date' => $p['birth_date'],
                'phone'      => $p['phone'] ?? null,
                'blood_type' => ['A','B','AB','O'][rand(0,3)],
                'allergy'    => $p['allergy'] ?? null,
                'address'    => 'Jl. Dummy No. '.rand(1,100).', Magetan',
            ]);
        }

        // ── 4. Medicines ────────────────────────────────────────────────────────
        $medData = [
            ['code'=>'OBT-001','name'=>'Paracetamol 500mg','unit'=>'tablet','stock'=>200,'price'=>2000,'description'=>'Analgesik dan antipiretik'],
            ['code'=>'OBT-002','name'=>'Amoxicillin 500mg','unit'=>'kapsul','stock'=>150,'price'=>5000,'description'=>'Antibiotik spektrum luas'],
            ['code'=>'OBT-003','name'=>'Omeprazole 20mg',  'unit'=>'kapsul','stock'=>100,'price'=>4000,'description'=>'Obat lambung'],
            ['code'=>'OBT-004','name'=>'Cetirizine 10mg',  'unit'=>'tablet','stock'=>8,  'price'=>3000,'description'=>'Antihistamin — stok rendah'],
            ['code'=>'OBT-005','name'=>'Metformin 500mg',  'unit'=>'tablet','stock'=>0,  'price'=>3500,'description'=>'Antidiabetes — stok habis'],
            ['code'=>'OBT-006','name'=>'Vitamin C 500mg',  'unit'=>'tablet','stock'=>300,'price'=>1500,'description'=>'Suplemen vitamin C'],
            ['code'=>'OBT-007','name'=>'Antasida Sirup',   'unit'=>'botol', 'stock'=>50, 'price'=>15000,'description'=>'Obat maag'],
            ['code'=>'OBT-008','name'=>'Salep Kulit 15g',  'unit'=>'tube',  'stock'=>30, 'price'=>12000,'description'=>'Antibakteri topikal'],
        ];
        foreach ($medData as $m) Medicine::firstOrCreate(['code'=>$m['code']], $m);

        // ── 5. Appointments + Rekam Medis + Resep + Tagihan ──────────────────
        $patients = Patient::all();
        $doctors  = Doctor::with(['user','department'])->get();

        if ($patients->isEmpty() || $doctors->isEmpty()) return;

        $statuses   = ['selesai','selesai','selesai','dikonfirmasi','menunggu'];
        $complaints = ['Demam dan pusing','Sakit gigi','Batuk berdahak','Kontrol rutin','Nyeri perut','Sakit kepala berulang'];
        $diagnoses  = ['ISPA ringan','Karies gigi','Bronkitis akut','Hipertensi terkontrol','Gastritis','Tension headache'];
        $treatments = ['Istirahat cukup, minum obat','Tambal gigi','Ekspektoran + antibiotik','Lanjut obat rutin','Diet rendah lemak','Analgesik + relaksasi'];

        for ($i = 0; $i < 15; $i++) {
            $patient = $patients->random();
            $doctor  = $doctors->random();
            $status  = $statuses[array_rand($statuses)];
            $date    = now()->subDays(rand(0, 14))->format('Y-m-d');
            $code    = 'APT-' . strtoupper(Str::random(3)) . '-' . now()->format('dmY') . $i;

            $apt = Appointment::create([
                'patient_id'       => $patient->id,
                'doctor_id'        => $doctor->id,
                'department_id'    => $doctor->department_id,
                'appointment_code' => $code,
                'appointment_date' => $date,
                'appointment_time' => sprintf('%02d:00:00', rand(8,11)),
                'complaint'        => $complaints[array_rand($complaints)],
                'status'           => $status,
            ]);

            if ($status === 'selesai') {
                $diag = $diagnoses[array_rand($diagnoses)];
                $rm = MedicalRecord::create([
                    'appointment_id' => $apt->id,
                    'patient_id'     => $patient->id,
                    'doctor_id'      => $doctor->id,
                    'visit_date'     => $date,
                    'anamnesis'      => $apt->complaint . '. Sudah berlangsung ' . rand(1,7) . ' hari.',
                    'diagnosis'      => $diag,
                    'treatment'      => $treatments[array_rand($treatments)],
                    'notes'          => 'Kontrol ulang ' . rand(3,7) . ' hari kemudian.',
                ]);

                // Buat resep
                $medicines = Medicine::where('stock','>',0)->inRandomOrder()->take(2)->get();
                if ($medicines->isNotEmpty()) {
                    $rx = Prescription::create([
                        'medical_record_id' => $rm->id,
                        'patient_id'        => $patient->id,
                        'doctor_id'         => $doctor->id,
                        'prescription_date' => $date,
                    ]);
                    foreach ($medicines as $med) {
                        $qty = rand(1,3) * 10;
                        PrescriptionDetail::create([
                            'prescription_id' => $rx->id,
                            'medicine_id'     => $med->id,
                            'dosage'          => '3x1',
                            'quantity'        => $qty,
                            'instructions'    => 'Sesudah makan',
                        ]);
                        $med->decrement('stock', min($qty, $med->stock));
                    }
                }

                // Buat tagihan
                $invoiceNo = 'INV-'.now()->format('Ymd').'-'.strtoupper(Str::random(4)).$i;
                $feeKonsul = $doctor->consultation_fee;
                $feeObat   = $medicines->sum(fn($m) => $m->price * rand(1,3) * 10);
                $total     = $feeKonsul + $feeObat;

                $bill = Bill::create([
                    'appointment_id' => $apt->id,
                    'patient_id'     => $patient->id,
                    'invoice_number' => $invoiceNo,
                    'total_amount'   => $total,
                    'status'         => rand(0,1) ? 'lunas' : 'belum_dibayar',
                    'bill_date'      => $date,
                ]);

                BillDetail::create(['bill_id'=>$bill->id,'description'=>'Biaya Konsultasi — '.$doctor->user->name,'qty'=>1,'price'=>$feeKonsul,'subtotal'=>$feeKonsul]);
                if ($feeObat > 0) {
                    BillDetail::create(['bill_id'=>$bill->id,'description'=>'Biaya Obat','qty'=>1,'price'=>$feeObat,'subtotal'=>$feeObat]);
                }

                if ($bill->status === 'lunas') {
                    Payment::create([
                        'bill_id'        => $bill->id,
                        'amount'         => $total,
                        'payment_method' => ['tunai','transfer','qris'][rand(0,2)],
                        'payment_date'   => $date.' '.sprintf('%02d:%02d:00',rand(8,16),rand(0,59)),
                    ]);
                }
            }
        }

        $this->command->info('✅ Data dummy berhasil dibuat!');
        $this->command->info('   Pasien: '.\App\Models\Patient::count());
        $this->command->info('   Dokter: '.\App\Models\Doctor::count());
        $this->command->info('   Appointment: '.\App\Models\Appointment::count());
        $this->command->info('   Rekam Medis: '.\App\Models\MedicalRecord::count());
        $this->command->info('   Tagihan: '.\App\Models\Bill::count());
    }
}
