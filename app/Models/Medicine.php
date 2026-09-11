<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'unit', 'stock', 'price', 'description'];

    public function prescriptionDetails()
    {
        return $this->hasMany(PrescriptionDetail::class);
    }
}
