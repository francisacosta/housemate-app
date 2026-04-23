<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conversation>
 */
class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'listing_id' => null,
            'created_by_user_id' => User::factory(),
            'conversation_type' => 'direct',
            'last_message_at' => null,
        ];
    }

    public function listingInquiry(): static
    {
        return $this->state(fn (array $attributes) => [
            'conversation_type' => 'listing_inquiry',
        ]);
    }
}
