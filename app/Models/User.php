<?php

namespace App\Models;

use App\Models\Admin\Store;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['cars'];

    //用戶店別
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_user', 'user_id', 'store_id');
    }

    // 給用戶分配店別
    public function assignStore($store)
    {
        return $this->stores()->save($store);
    }

    //店別整體新增與修改
    public function giveStoreTo(array $StoreId)
    {
        $this->stores()->detach();
        $stores = Store::whereIn('id', $StoreId)->get();
        foreach ($stores as $v) {
            $this->assignStore($v);
        }

        return true;
    }

    /**
     *  Setter for regular_appear_at_time column separate by commas
     */
    public function setRegularAppearAtTimeAttribute($value)
    {
        $this->attributes['regular_appear_at_time'] = implode(',', $value);
    }

    /**
     *  Setter for regular_appear_at column separate by commas seeter
     */
    public function setRegularAppearAtAttribute($value)
    {
        $this->attributes['regular_appear_at'] = implode(',', $value);
    }

    /**
     *  Getter for regular_appear_at_time column separate by commas
     */
    public function getRegularAppearAtTimeAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     *  Getter for regular_appear_at column separate by commas
     */
    public function getRegularAppearAtAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * cars relation ship
     *
     * @return void
     */
    public function cars()
    {
        return $this->hasMany(CustomerCar::class, 'customer_id');
    }
}
