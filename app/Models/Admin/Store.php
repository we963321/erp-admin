<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';

    public function admin_user()
    {
        return $this->hasOne(AdminUser::class, 'id', 'admin_user_id');
    }

}
