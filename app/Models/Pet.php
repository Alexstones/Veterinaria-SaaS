<?php

namespace App\Models;

use App\Traits\Multitenant;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use Multitenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'type',
        'species',
        'sex',
        'size',
        'age',
        'location',
        'description',
        'contact_info',
        'image_url',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'contact_info' => 'json',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
