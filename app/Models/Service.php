<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'service_category_id', 'name', 'slug', 'short_description', 'meta_description', 'detail_content',
        'icon', 'image', 'listing_image',
        'price_original', 'price_sale', 'rating', 'duration_mins', 'warranty_days',
        'is_featured', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_original' => 'decimal:2',
            'price_sale' => 'decimal:2',
            'rating' => 'decimal:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function discountPercent(): int
    {
        if ($this->price_original <= 0) {
            return 0;
        }

        return (int) round((1 - ($this->price_sale / $this->price_original)) * 100);
    }

    public function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    public function cardImageUrl(): ?string
    {
        return $this->assetUrl($this->image);
    }

    public function listingImageUrl(): ?string
    {
        return $this->assetUrl($this->listing_image ?: $this->image);
    }

    public function displayTitle(): string
    {
        if (str_contains(strtolower($this->name), 'repair') || str_contains(strtolower($this->name), 'service')) {
            return $this->name;
        }

        return $this->name.' Repair & Service';
    }
}
