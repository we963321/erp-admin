<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //用戶角色
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role_user', 'user_id', 'role_id');
    }

    //用戶店別
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_admin_user', 'user_id', 'store_id');
    }

    // 判斷用戶是否具有某個角色
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    // 判斷用戶是否具有某權限
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
            if (!$permission) return false;
        }

        return $this->hasRole($permission->roles);
    }

    // 給用戶分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    //角色整體新增與修改
    public function giveRoleTo(array $RoleId)
    {
        $this->roles()->detach();
        $roles = Role::whereIn('id', $RoleId)->get();
        foreach ($roles as $v) {
            $this->assignRole($v);
        }

        return true;
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
