<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePrivilegeMapping extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_privilege_map_id';

    protected $fillable = [
        'privilege_id',
        'role_id'

    ];
}
