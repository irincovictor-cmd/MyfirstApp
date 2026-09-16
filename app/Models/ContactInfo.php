<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInfo extends Model
{
    protected $table = 'tblcontactinfo';

    protected $fillable = [
        'blooddonor_id',
        'requirer_id',
        'phone',
        'email',
        'contact_person',
    ];

    public function bloodDonor(): BelongsTo
    {
        return $this->belongsTo(BloodDonor::class, 'blooddonor_id');
    }

    public function requirer(): BelongsTo
    {
        return $this->belongsTo(Requirer::class, 'requirer_id');
    }
}
