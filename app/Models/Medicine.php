<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['code', 'name', 'unit', 'stock', 'price', 'description'];

    public function prescriptionDetails()
    {
        return $this->hasMany(PrescriptionDetail::class);
    }
}
