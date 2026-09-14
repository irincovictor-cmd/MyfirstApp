<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDetail extends Model
{
    /**
     * Table name (matches course sample).
     */
    protected $table = 'studentdetails';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'address',
        'contact',
    ];

    /**
     * Detail belongs to one student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
