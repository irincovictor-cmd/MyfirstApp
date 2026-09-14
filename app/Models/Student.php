<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'course',
        'age',
    ];

    /**
     * A student can have one detail record (address + contact).
     */
    public function detail(): HasOne
    {
        return $this->hasOne(StudentDetail::class);
    }
}
