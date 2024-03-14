<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $primaryKey = "labor_id";
    protected $fillable = [
        'labor_name', 
        'location',
    ];

    public function rates()
    {
        return $this->hasMany(LaborRate::class, 'labor_id');
    }
}
