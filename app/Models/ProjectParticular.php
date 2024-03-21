<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticular extends Model
{
    protected $primaryKey = 'project_particular_id';

    protected $fillable = [
        'project_id',
        'particular_id',
        'description',
        'remark',
        'total',
    ];

    protected $table = 'project_particulars';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function particular()
    {
        return $this->belongsTo(Particular::class);
    }

    public function materials()
    {
        return $this->hasMany(ProjectParticularMaterial::class, 'project_particular_id');
    }

    // Define the relationship with labors
    public function labors()
    {
        return $this->hasMany(ProjectParticularLabor::class, 'project_particular_id');
    }

    public function equipments()
    {
        return $this->hasMany(ProjectParticularEquipment::class, 'project_particular_id');
    }
}
