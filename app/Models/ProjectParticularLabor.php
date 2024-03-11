<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticularLabor extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_particular_labor_id';

    public function particular()
    {
        return $this->belongsTo(ProjectParticular::class, 'project_particular_id');
    }

    public function labor()
    {
        return $this->belongsTo(Labor::class);
    }
}

