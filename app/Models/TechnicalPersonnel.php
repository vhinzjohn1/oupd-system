<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalPersonnel extends Model
{
    protected $primaryKey = 'technical_personnel_id';

    protected $fillable = [
        'personnel_description',
        'personnel_no',
        'project_id',

    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}