<?php

namespace App\Models;

use Database\Factories\ProfilePreferenceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'profile_id',
    'cleanliness_level',
    'smoking_preference',
    'drinking_preference',
    'pet_preference',
    'sleep_schedule',
    'guest_policy',
    'noise_tolerance',
    'cooking_habit',
    'work_schedule',
    'can_share_room',
    'preferred_housemate_gender',
    'max_housemates_preference',
    'dealbreakers_text',
    'household_rules_text',
])]
class ProfilePreference extends Model
{
    /** @use HasFactory<ProfilePreferenceFactory> */
    use HasFactory;

    protected $primaryKey = 'profile_id';

    public $incrementing = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'can_share_room' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
