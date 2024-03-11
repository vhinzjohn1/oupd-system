<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $primaryKey = 'equipment_id';
    protected $fillable = [
        'equipment_name',
        'equipment_category_id',
        'equipment_model',
        'equipment_capacity'
    ];

    protected $table = 'equipments';

    // In your Equipment model
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id'); // Specify the existing column name
    }

    public function rates()
    {
        return $this->hasMany(EquipmentRate::class, 'equipment_rate_id');
    }
}
