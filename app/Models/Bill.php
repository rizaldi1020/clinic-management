<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id', 'patient_id', 'invoice_number', 'total_amount', 'status', 'bill_date',
    ];

    protected $casts = [
        'bill_date' => 'date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function details()
    {
        return $this->hasMany(BillDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
