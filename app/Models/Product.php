<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'product_category_id',
        'name',
        'stock',
    ];
    
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function stockLogs(){
        return $this->hasMany(StockLog::class);
    }

    public function guests(){
        return $this->belongsToMany(Guest::class, 'guest_product')
                    ->withPivot('category_id')
                    ->withTimestamps();
    }
}


