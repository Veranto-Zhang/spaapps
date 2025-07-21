<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'bed_count',
    ];

    public function assignments(){
        return $this->hasMany(Assignment::class);
    }

}
