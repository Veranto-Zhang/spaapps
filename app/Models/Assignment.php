<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'room_id',
        'trx_no',
        'date',
        'start_time',
        'remark',
        'contact',

    ];

    protected $casts = [
        'date' => 'date',
        'duration_in_min' => 'integer',
    ];

    protected static function booted()
    {
        static::deleting(function ($assignment) {
            if ($assignment->isForceDeleting()) {
                // Permanently delete guests
                $assignment->guests()->forceDelete();
            } else {
                // Soft delete guests
                $assignment->guests()->delete();
            }
        });
    }


    public function guests() {
        return $this->hasMany(Guest::class)->withTrashed();
    }
    public function room() {
        return $this->belongsTo(Room::class);
    }
}
