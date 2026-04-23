<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Message;
use App\Models\Profile;
use App\Models\ProfilePreference;
use App\Models\RoommatePost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class MvpDemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(7)->create();

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = $users->prepend($testUser)->values();

        $users->each(function (User $user): void {
            $profile = Profile::factory()
                ->for($user)
                ->published()
                ->create([
                    'display_name' => $user->name,
                ]);

            ProfilePreference::factory()
                ->for($profile)
                ->create();
        });

        $users->take(5)->each(function (User $user): void {
            RoommatePost::factory()
                ->for($user)
                ->published()
                ->create([
                    'title' => match ($user->id % 3) {
                        0 => 'Looking for a calm roommate before locking a place',
                        1 => 'Open to joining a shared condo in a walkable area',
                        default => 'Trying to form a small group before renting',
                    },
                    'city_municipality' => $user->profile->city_municipality,
                    'district_or_barangay' => $user->profile->district_or_barangay,
                    'province' => $user->profile->province,
                    'region' => $user->profile->region,
                    'budget_min_centavos' => $user->profile->budget_min_centavos,
                    'budget_max_centavos' => $user->profile->budget_max_centavos,
                    'move_in_date' => $user->profile->move_in_date,
                    'preferred_property_type' => $user->profile->preferred_property_type,
                    'roommate_intent' => $user->profile->roommate_intent,
                ]);
        });

        $hostUsers = $users->take(4)->values();
        $listings = new Collection;

        $hostUsers->each(function (User $host, int $index) use ($listings): void {
            $listing = Listing::factory()
                ->for($host)
                ->published()
                ->create();

            ListingPhoto::factory()->for($listing)->create([
                'sort_order' => 0,
                'is_cover' => true,
            ]);

            $extraPhotoCount = $index % 3;

            for ($photoIndex = 1; $photoIndex <= $extraPhotoCount; $photoIndex++) {
                ListingPhoto::factory()->for($listing)->create([
                    'sort_order' => $photoIndex,
                ]);
            }

            $listings->push($listing);
        });

        $listings->each(function (Listing $listing, int $index) use ($users): void {
            $host = $listing->user;
            $inquirer = $users[($index + 4) % $users->count()];

            if ($inquirer->is($host)) {
                $inquirer = $users[($index + 5) % $users->count()];
            }

            $conversation = Conversation::factory()
                ->for($listing)
                ->listingInquiry()
                ->create([
                    'created_by_user_id' => $inquirer->id,
                ]);

            $hostParticipant = ConversationParticipant::factory()->create([
                'conversation_id' => $conversation->id,
                'user_id' => $host->id,
            ]);

            $inquirerParticipant = ConversationParticipant::factory()->create([
                'conversation_id' => $conversation->id,
                'user_id' => $inquirer->id,
            ]);

            $firstMessage = Message::factory()->create([
                'conversation_id' => $conversation->id,
                'sender_user_id' => $inquirer->id,
                'body' => 'Hi, I am interested in the listing. Is the room still available?',
                'created_at' => now()->subDays(5 - $index)->setTime(9, 15),
                'updated_at' => now()->subDays(5 - $index)->setTime(9, 15),
            ]);

            $secondMessage = Message::factory()->create([
                'conversation_id' => $conversation->id,
                'sender_user_id' => $host->id,
                'body' => 'Yes, it is still available. I can share more details if you want.',
                'created_at' => now()->subDays(5 - $index)->setTime(10, 0),
                'updated_at' => now()->subDays(5 - $index)->setTime(10, 0),
            ]);

            $thirdMessage = Message::factory()->create([
                'conversation_id' => $conversation->id,
                'sender_user_id' => $inquirer->id,
                'body' => 'That would help. I am looking to move in next month and prefer a quiet unit.',
                'created_at' => now()->subDays(5 - $index)->setTime(10, 20),
                'updated_at' => now()->subDays(5 - $index)->setTime(10, 20),
            ]);

            $conversation->forceFill([
                'last_message_at' => $thirdMessage->created_at,
            ])->save();

            $hostParticipant->forceFill([
                'last_read_message_id' => $secondMessage->id,
            ])->save();

            $inquirerParticipant->forceFill([
                'last_read_message_id' => $thirdMessage->id,
            ])->save();

        });

        $directConversation = Conversation::factory()->create([
            'created_by_user_id' => $users[0]->id,
            'conversation_type' => 'direct',
        ]);

        $directIntro = Message::factory()->create([
            'conversation_id' => $directConversation->id,
            'sender_user_id' => $users[0]->id,
            'body' => 'Hi, I saw your profile and think our living preferences line up well.',
            'created_at' => now()->subDay()->setTime(19, 30),
            'updated_at' => now()->subDay()->setTime(19, 30),
        ]);

        Message::factory()->create([
            'conversation_id' => $directConversation->id,
            'sender_user_id' => $users[1]->id,
            'body' => 'Thanks for reaching out. I am open to a quick chat about move-in plans.',
            'created_at' => now()->subDay()->setTime(19, 45),
            'updated_at' => now()->subDay()->setTime(19, 45),
        ]);

        ConversationParticipant::factory()->create([
            'conversation_id' => $directConversation->id,
            'user_id' => $users[0]->id,
            'last_read_message_id' => $directIntro->id,
        ]);

        ConversationParticipant::factory()->create([
            'conversation_id' => $directConversation->id,
            'user_id' => $users[1]->id,
        ]);

        $directConversation->forceFill([
            'last_message_at' => now()->subDay()->setTime(19, 45),
        ])->save();
    }
}
