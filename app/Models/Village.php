<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    protected $fillable = ['union_id', 'name', 'bn_name'];

    public function union(): BelongsTo
    {
        return $this->belongsTo(Union::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
