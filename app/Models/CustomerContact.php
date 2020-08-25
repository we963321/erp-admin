<?php

namespace App\Models;

use App\Models\Admin\AdminUser;
use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    const FROM_ADMIN = 1;
    const FROM_CUSTOMER = 2;

    protected $guarded = [];

    protected $with = ['customer', 'parent', 'manager'];

    protected $appends = ['customer_name'];

    public function getCustomerNameAttribute()
    {
        return $this->customer->name ?? 'none';
    }

    /**
     * Child contact action
     */
    public function actions()
    {
        return $this->hasMany(self::class, 'contact_id');
    }

    /**
     * Parent contact
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'contact_id');
    }

    /**
     * Customer relationship
     */
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return void
     */
    public function manager()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    public function scopeRootContact($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('contact_id')->orWhere('contact_id', '');
        });
    }

    public function scopeFromAdmin($query)
    {
        return $query->where('direction', self::FROM_ADMIN);
    }

    public function scopeFromCustomer($query)
    {
        return $query->where('direction', self::FROM_CUSTOMER);
    }
}
