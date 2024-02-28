<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{

    protected $primaryKey = 'material_id';

    protected $fillable = [
        'material_name',
        'material_category_id',
        'unit_id',
        'price_id',
        'quarter_id',
        'year_id',
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id', 'material_category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }


    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'price_id');
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
