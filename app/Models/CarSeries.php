<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarSeries extends Model
{
    //
    protected $guarded = [];

    protected $with = ['brand'];
    protected $appends = ['brand_name'];

    public function getBrandNameAttribute()
    {
        return $this->brand->name ?? '';
    }
    /**
     * The relationship with parent brand
     *
     * @return void
     */
    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }
}
