<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectParticularLabor extends Model
{
    use HasFactory;

    protected $primaryKey = 'project_particular_labor_id';

    protected $fillable = [
        'project_particular_id',
        'labor_id',
        'no_of_persons',
        'work_days',
    ];

    public function particular()
    {
        return $this->belongsTo(ProjectParticular::class, 'project_particular_id');
    }

    public function labor()
    {
        return $this->belongsTo(Labor::class);
    }
}

