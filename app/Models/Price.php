<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['price', 'quarter_id', 'year_id'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    // Define relationship with Quarter model
    public function quarter()
    {
        return $this->belongsTo(Quarter::class, 'quarter_id', 'quarter_id');
    }

    // Define relationship with Year model
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'year_id');
    }
}
