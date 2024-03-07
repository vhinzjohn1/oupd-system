<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    protected $primaryKey = 'eq_cat_id';
    protected $fillable = [
        'eq_cat_name',
        'eq_cat_desc'
    ];

    public function Equipments()
    {
        return $this->hasMany(Equipment::class, 'equipment_id');
    }
}
