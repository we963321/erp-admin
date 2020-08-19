<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $guarded = [];

    /**
     * Scope for taiwan cities
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    public function scopeTaiwanCities($query)
    {
        return $query->whereHas('parent', function ($query) {
            $query->where('code', 'A001');
        });
    }

    /**
     * Parent relation ship
     */
    public function parent()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
