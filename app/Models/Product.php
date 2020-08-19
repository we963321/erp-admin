<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    public function product_category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'product_category_id');
    }
}
