<?php
// app/Models/Quarter.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    protected $primaryKey = 'quarter_id';

    public function prices()
    {
        return $this->hasMany(Price::class, 'quarter_id', 'quarter_id');
    }
}
