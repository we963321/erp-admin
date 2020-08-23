<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    protected $guarded = [];

    /**
     * Relationship with series
     */
    public function series()
    {
        return $this->hasMany(CarSeries::class, 'brand_id');
    }
}
