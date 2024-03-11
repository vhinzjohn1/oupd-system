<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentRate extends Model
{
    protected $primaryKey = 'equipment_rate_id';
    protected $fillable = [
        'rate',
        'equipment_id',
        'is_active',
        'date_effective',
    ];

    protected $dates = ['date_effective'];

    public function Equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
