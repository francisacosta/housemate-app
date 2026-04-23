<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'user_id',
    'display_name',
    'avatar_path',
    'headline',
    'bio',
    'occupation',
    'work_setup',
    'age_bracket',
    'gender_identity',
    'budget_min_centavos',
    'budget_max_centavos',
    'move_in_date',
    'region',
    'province',
    'city_municipality',
    'district_or_barangay',
    'roommate_intent',
    'preferred_property_type',
    'visibility_status',
    'published_at',
])]
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'move_in_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(ProfilePreference::class);
    }

    public static function defaultAvatarUrl(): string
    {
        return asset('default-profile-photo.svg');
    }

    public function hasAvatar(): bool
    {
        return filled($this->avatar_path) && Storage::disk('public')->exists($this->avatar_path);
    }

    public function avatarUrl(): string
    {
        if (! $this->hasAvatar()) {
            return static::defaultAvatarUrl();
        }

        return Storage::disk('public')->url($this->avatar_path);
    }
}
