<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Particular extends Model
{
    protected $primaryKey = 'particular_id';
    protected $fillable = ['particular_name', 'pay_item'];

    public function projectParticular()
    {
        return $this->belongsTo(ProjectParticular::class, 'particular_id', 'particular_id');
    }
}
