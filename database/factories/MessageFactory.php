<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'sender_user_id' => User::factory(),
            'body' => fake()->randomElement([
                'Hi, is this still available?',
                'Can you share more about the unit and current housemates?',
                'I am interested and could move in next month.',
                'Would it be possible to schedule a viewing this weekend?',
                'Thanks, that setup sounds like a good fit for me.',
            ]),
        ];
    }
}
