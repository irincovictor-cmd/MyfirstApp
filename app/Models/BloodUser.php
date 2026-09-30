<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodUser extends Model
{
    protected $table = 'blood_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
