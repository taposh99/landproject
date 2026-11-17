<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Union extends Model
{
    use HasFactory;

    protected $fillable = ['upazila_id', 'name', 'bn_name'];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
