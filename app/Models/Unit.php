<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $primaryKey = 'unit_id';
    
    protected $fillable = ['unit_name'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
