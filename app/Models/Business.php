<?php

namespace App\Models;

use App\Traits\Multitenant;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use Multitenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'category',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
