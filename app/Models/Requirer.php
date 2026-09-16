<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Requirer extends Model
{
    protected $table = 'tblrequirer';

    protected $fillable = [
        'admin_id',
        'first_name',
        'last_name',
        'blood_type',
        'required_date',
        'units_needed',
        'hospital',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function contactInfo(): HasOne
    {
        return $this->hasOne(ContactInfo::class, 'requirer_id');
    }
}
