<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bn_name'];

    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
