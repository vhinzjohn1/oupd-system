<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    protected $primaryKey = 'price_id';
    protected $fillable = ['price', 'status', 'quarter', 'year', 'material_id'];

    public function materials()
    {
        return $this->belongsTo(Material::class);
    }
}
