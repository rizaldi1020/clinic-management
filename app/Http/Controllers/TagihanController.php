<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BillPaid;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with(['patient', 'appointment.department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('patient', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('bill_date', $request->date);
        }

        $bills = $query->latest('bill_date')->paginate(20)->withQueryString();

        return view('tagihan.index', compact('bills'));
    }

    public function create(Request $request)
    {
        $appointment = null;
        if ($request->filled('appointment_id')) {
            $appointment = Appointment::with([
                'patient', 'doctor', 'department',
                'medicalRecord.prescriptions.details.medicine'
            ])->findOrFail($request->appointment_id);

            if ($appointment->bill) {
                return redirect()->route('tagihan.show', $appointment->bill)
                    ->with('success', 'Tagihan untuk janji temu ini sudah ada.');
            }
        }

        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'selesai')
            ->whereDoesntHave('bill')
            ->orderByDesc('appointment_date')
            ->get();

        return view('tagihan.create', compact('appointment', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id'      => 'required|exists:appointments,id|unique:bills,appointment_id',
            'bill_date'           => 'required|date',
            'items'               => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.price'       => 'required|numeric|min:0',
        ], [
            'appointment_id.unique' => 'Tagihan untuk janji temu ini sudah ada.',
            'items.required'        => 'Tambahkan minimal 1 item tagihan.',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $invoiceNo   = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

        DB::transaction(function () use ($request, $appointment, $invoiceNo) {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['qty'] * $item['price'];
            }

            $bill = Bill::create([
                'appointment_id' => $appointment->id,
                'patient_id'     => $appointment->patient_id,
                'invoice_number' => $invoiceNo,
                'total_amount'   => $total,
                'status'         => 'belum_dibayar',
                'bill_date'      => $request->bill_date,
            ]);

            foreach ($request->items as $item) {
                BillDetail::create([
                    'bill_id'     => $bill->id,
                    'description' => $item['description'],
                    'qty'         => (int)$item['qty'],
                    'price'       => $item['price'],
                    'subtotal'    => $item['qty'] * $item['price'],
                ]);
            }
        });

        return redirect()->route('tagihan.index')
            ->with('success', "Tagihan {$invoiceNo} berhasil dibuat.");
    }

    public function show(Bill $tagihan)
    {
        $tagihan->load(['patient', 'appointment.doctor.user', 'appointment.department', 'details', 'payments']);
        return view('tagihan.show', compact('tagihan'));
    }

    public function destroy(Bill $tagihan)
    {
        if ($tagihan->status === 'lunas') {
            return back()->withErrors(['delete' => 'Tagihan yang sudah lunas tidak bisa dihapus.']);
        }
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function storePayment(Request $request, Bill $tagihan)
    {
        $request->validate([
            'amount'           => 'required|numeric|min:1',
            'payment_method'   => 'required|in:tunai,debit,kredit,transfer,qris,bpjs,asuransi',
            'payment_date'     => 'required|date',
            'reference_number' => 'nullable|string|max:50',
        ]);

        $totalPaid = $tagihan->payments->sum('amount') + $request->amount;

        Payment::create([
            'bill_id'          => $tagihan->id,
            'amount'           => $request->amount,
            'payment_method'   => $request->payment_method,
            'payment_date'     => $request->payment_date,
            'reference_number' => $request->reference_number,
        ]);

        if ($totalPaid >= $tagihan->total_amount) {
            $tagihan->update(['status' => 'lunas']);
            $msg = 'Pembayaran diterima. Tagihan telah LUNAS!';
            
            if ($totalPaid >= $tagihan->total_amount) {
        $tagihan->update(['status' => 'lunas']);

        // Kirim email bukti pembayaran
        $patientEmail = $tagihan->patient->user?->email;
        if ($patientEmail) {
            try {
                $tagihan->load(['details', 'payments', 'appointment.doctor.user']);
                Mail::to($patientEmail)->send(new BillPaid($tagihan));
            } catch (\Exception $e) {
                \Log::warning('Gagal kirim email bukti bayar: ' . $e->getMessage());
            }
        }

        $msg = 'Pembayaran diterima. Tagihan telah LUNAS!';
        }

        } else {
            $sisa = number_format($tagihan->total_amount - $totalPaid, 0, ',', '.');
            $msg  = "Pembayaran diterima. Sisa: Rp {$sisa}";
        }

        return back()->with('success', $msg);
    }
}
