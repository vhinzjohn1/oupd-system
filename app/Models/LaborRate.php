<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaborRate extends Model
{
    protected $primaryKey = 'labor_rate_id';
    protected $fillable = [
        'rate',
        'labor_id',
        'is_active',
        'date_effective',
    ];

    // protected $dates = ['date_effective'];

    public function labors()
    {
        return $this->belongsTo(Labor::class);
    }
}
