<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    //
    protected $fillable = [
        'product_id',
        'old_stock',
        'new_stock',
        'changed_by',
    ];
    
    public function user()
{
    return $this->belongsTo(User::class, 'changed_by');
}
}
