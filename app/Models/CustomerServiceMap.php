<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerServiceMap extends Model
{	
	protected $guarded = [];

	public $timestamps = false;

    protected $table = 'customer_service_map';

    public function service()
    {
        return $this->belongsTo(CustomerService::class);
    }
}
