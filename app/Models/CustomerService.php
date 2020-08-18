<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    protected $table = 'customer_service';

    public function customer_category()
    {
        return $this->hasOne(CustomerCategory::class, 'id', 'customer_category_id');
    }
}
