<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCar extends Model
{
    protected $guarded = [];

    const CAR_BOUGHT_NEW = 1;

    const CAR_BOUGHT_RENT = 2;

    const CAR_BOUGHT_OLD = 3;

    /** 小/中型房車 */
    const CAR_TYPE_SMALL = 1;
    /** 大型房車 */
    const CAR_TYPE_LARGE = 2;
    /** 休旅車 */
    const CAR_TYPE_CRV = 3;
    /** 七人 RV 車 */
    const CAR_TYPE_RV_7 = 4;
    /** 小型機車 */
    const CAR_TYPE_SCOOTER = 5;
    /** 中型仿賽機車 */
    const CAR_TYPE_SCOOTER_RACE = 6;
    /** 中型街車機車 */
    const CAR_TYPE_SCOOTER_STREET = 7;
    /** 公升級仿賽機車 */
    const CAR_TYPE_SCOOTER_RACE_LARGE = 8;

    protected $with = ['series'];

    /**
     * Series relation ship
     */
    public function series()
    {
        return $this->belongsTo(CarSeries::class);
    }
}
