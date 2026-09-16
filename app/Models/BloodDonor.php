<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodDonor extends Model
{
    protected $table = 'tblblooddonors';

    protected $fillable = [
        'admin_id',
        'first_name',
        'last_name',
        'blood_type',
        'birth_date',
        'gender',
        'address',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function contactInfo(): HasOne
    {
        return $this->hasOne(ContactInfo::class, 'blooddonor_id');
    }
}
