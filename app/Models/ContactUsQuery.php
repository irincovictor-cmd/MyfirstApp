<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUsQuery extends Model
{
    protected $table = 'tblcontactusquery';

    protected $fillable = [
        'admin_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
