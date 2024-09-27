<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinimumEquipment extends Model
{
    protected $primaryKey = 'minimum_equipment_id';

    protected $fillable = [
        'min_equip_description',
        'min_equip_owned',
        'min_equip_lease',
        'min_equip_totalUnits',
        'project_id',

    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}