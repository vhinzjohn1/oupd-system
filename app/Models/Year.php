<?php

// app/Models/Year.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{

    protected $fillable = ['year'];

    public function prices()
    {
        return $this->hasMany(Price::class, 'year_id', 'year_id');
    }
}
