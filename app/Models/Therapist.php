<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Therapist extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'phone',
        'is_available',
    ];

    

    public function guests(){
        return $this->hasMany(Guest::class);
    }
}
