<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    protected $primaryKey = 'equipment_category_id';
    protected $fillable = [
        'equipment_category_name',
        // 'equipment_category_desc'
    ];

    public function Equipments()
    {
        return $this->hasMany(Equipment::class, 'equipment_id');
    }
}
