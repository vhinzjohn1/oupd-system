<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    protected $primaryKey = 'price_id';
    protected $fillable = ['price'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
