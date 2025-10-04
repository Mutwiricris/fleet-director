<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'description',
        'street_address',
        'city',
        'state',
        'postal_code',
        'country',
        'logo_path',
        'industry',
        // 'tax_id',
        'status',
    ];

    public function directors()
    {
        return $this->hasMany(Director::class);
    }
}
