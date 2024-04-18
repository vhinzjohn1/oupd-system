<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $primaryKey = 'signature_id';

    protected $fillable = [
        'fullname',
        'degree',
        'position',
        'role',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
