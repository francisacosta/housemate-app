<?php

namespace App\Models;

use Database\Factories\RoommatePostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'title',
    'description',
    'status',
    'post_type',
    'budget_min_centavos',
    'budget_max_centavos',
    'move_in_date',
    'preferred_property_type',
    'region',
    'province',
    'city_municipality',
    'district_or_barangay',
    'roommate_intent',
    'published_at',
])]
class RoommatePost extends Model
{
    /** @use HasFactory<RoommatePostFactory> */
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
}
