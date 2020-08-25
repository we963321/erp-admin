<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    protected $table = 'customer_category';

    public function customer_service()
    {
        return $this->hasMany(CustomerService::class, 'customer_category_id', 'id');
    }
}
