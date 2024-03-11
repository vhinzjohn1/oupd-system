<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'project_id';
    protected $fillable = [
        'project_title',
        'project_location',
        'project_owner',
        'unit_office',
        'project_description',
        'project_contract_duration',
        'project_date_prepared',
        'project_target_start_date',
        'project_appropriation',
        'project_source_of_fund',
        'project_mode_of_implementation',
    ];

    public function projectParticulars()
    {
        return $this->hasMany(ProjectParticular::class);
    }
}
