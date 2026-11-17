<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'district_id',
        'upazila_id',
        'mouza_area',
        'title',
        'slug',
        'description',
        'land_type',
        'land_size',
        'size_unit',
        'price',
        'price_type',
        'is_negotiable',
        'road_width_feet',
        'road_type',
        'address',
        'latitude',
        'longitude',
        'khatian_type',
        'daag_no',
        'khatian_no',
        'is_mutation_done',
        'is_tax_updated',
        'contact_number',
        'whatsapp_number',
        'status',
        'is_verified',
        'is_featured',
        'rejection_reason',
        'featured_image',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_negotiable' => 'boolean',
            'is_mutation_done' => 'boolean',
            'is_tax_updated' => 'boolean',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'land_size' => 'decimal:2',
            'price' => 'decimal:2',
            'road_width_feet' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function getFormattedPriceAttribute(): string
    {
        $price = (float) $this->price;
        if ($price >= 10000000) {
            return number_format($price / 10000000, 2).' কোটি টাকা';
        }
        if ($price >= 100000) {
            return number_format($price / 100000, 2).' লাখ টাকা';
        }

        return number_format($price).' টাকা';
    }

    public function getLandTypeBanglaAttribute(): string
    {
        return match ($this->land_type) {
            'residential' => 'আবাসিক জমি',
            'commercial' => 'বাণিজ্যিক জমি',
            'agricultural' => 'কৃষি জমি',
            'industrial' => 'শিল্প কারখানার জমি',
            default => 'জমি',
        };
    }

    public function getSizeUnitBanglaAttribute(): string
    {
        return match ($this->size_unit) {
            'decimal' => 'শতাংশ',
            'katha' => 'কাঠা',
            'bigha' => 'বিঘা',
            'acre' => 'একর',
            default => $this->size_unit,
        };
    }
}
