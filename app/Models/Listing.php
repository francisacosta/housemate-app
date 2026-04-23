<?php

namespace App\Models;

use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

#[Fillable([
    'user_id',
    'title',
    'description',
    'status',
    'property_type',
    'space_type',
    'monthly_rent_centavos',
    'deposit_centavos',
    'available_from',
    'minimum_stay_months',
    'furnished',
    'utilities_included',
    'available_slots',
    'current_occupants',
    'region',
    'province',
    'city_municipality',
    'district_or_barangay',
    'address_private',
    'latitude',
    'longitude',
    'allows_smoking',
    'allows_pets',
    'preferred_tenant_gender',
    'published_at',
])]
class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'available_from' => 'date',
            'furnished' => 'boolean',
            'utilities_included' => 'boolean',
            'allows_smoking' => 'boolean',
            'allows_pets' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class);
    }

    /**
     * @return Collection<int, ListingPhoto>
     */
    public function displayPhotos(): Collection
    {
        return $this->photos
            ->filter(fn (ListingPhoto $photo): bool => $photo->hasPublicFile())
            ->sortBy('sort_order')
            ->values();
    }

    public function primaryPhoto(): ?ListingPhoto
    {
        $displayPhotos = $this->displayPhotos();

        return $displayPhotos->firstWhere('is_cover', true) ?? $displayPhotos->first();
    }

    public function coverPhotoUrl(): string
    {
        return $this->primaryPhoto()?->publicUrl() ?? ListingPhoto::defaultUrl();
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
