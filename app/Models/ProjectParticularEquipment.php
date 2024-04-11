<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticularEquipment extends Model
{
    use HasFactory;
    protected $table = 'project_particular_equipments';
    protected $primaryKey = 'project_particular_equipment_id';

    protected $fillable = ['project_particular_id', 'equipment_id', 'no_of_units', 'work_days'];

    public function projectParticular()
    {
        return $this->belongsTo(ProjectParticular::class, 'project_particular_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
    public function particular()
    {
        return $this->belongsTo(ProjectParticular::class, 'project_particular_id');
    }
}
