<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticularMaterial extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_particular_material_id';

    public function particular()
    {
        return $this->belongsTo(ProjectParticular::class, 'project_particular_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
