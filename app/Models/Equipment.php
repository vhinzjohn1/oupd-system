<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $primaryKey = 'equipment_id';
    protected $fillable = [
        'equipment_name',
        'eq_cat_id',
        'equipment_model',
        'equipment_capacity'
    ];

    // In your Equipment model
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'eq_cat_id'); // Specify the existing column name
    }

    public function rates()
    {
        return $this->hasMany(EquipmentRate::class, 'eq_rate_id');
    }

}
