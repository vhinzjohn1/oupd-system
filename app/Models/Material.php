<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $primaryKey = "material_id";
    protected $fillable = [
        'material_name',
        'unit',
        'material_category_id',
    ];

    // In your Material model
    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id'); // Specify the existing column name
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'material_id');
    }

}
