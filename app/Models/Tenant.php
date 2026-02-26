<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
