<?php
// app/Models/MaterialCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $primaryKey = "material_category_id";
    protected $fillable = ['material_category_name'];

    public function materials()
    {
        return $this->hasMany(Material::class, 'material_id');
    }
}
