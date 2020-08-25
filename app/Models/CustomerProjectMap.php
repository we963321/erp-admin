<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProjectMap extends Model
{	
	protected $guarded = [];

	public $timestamps = false;

    protected $table = 'customer_project_map';

    public function project()
    {
        return $this->belongsTo(CustomerProject::class);
    }
}
