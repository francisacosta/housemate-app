<?php

namespace App\Models;

use Database\Factories\ListingPhotoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'listing_id',
    'storage_path',
    'sort_order',
    'is_cover',
])]
class ListingPhoto extends Model
{
    /** @use HasFactory<ListingPhotoFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public static function defaultUrl(): string
    {
        return asset('default-listing-photo.svg');
    }

    public function hasPublicFile(): bool
    {
        return filled($this->storage_path) && Storage::disk('public')->exists($this->storage_path);
    }

    public function publicUrl(): string
    {
        if (! $this->hasPublicFile()) {
            return static::defaultUrl();
        }

        return Storage::disk('public')->url($this->storage_path);
    }
}
