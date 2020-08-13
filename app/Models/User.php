<?php

namespace App\Models;

use App\Models\Admin\Store;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
}
