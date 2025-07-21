<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'treatment_id',
        'therapist_id',
        'name',
        'duration_in_min',
    ];

    public function therapist() {
        return $this->belongsTo(Therapist::class);
    }

    public function treatment() {
        return $this->belongsTo(Treatment::class);
    }

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }
}
