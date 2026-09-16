<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $table = 'tbladmin';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function bloodDonors(): HasMany
    {
        return $this->hasMany(BloodDonor::class, 'admin_id');
    }

    public function requirers(): HasMany
    {
        return $this->hasMany(Requirer::class, 'admin_id');
    }

    public function contactQueries(): HasMany
    {
        return $this->hasMany(ContactUsQuery::class, 'admin_id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class, 'admin_id');
    }
}
