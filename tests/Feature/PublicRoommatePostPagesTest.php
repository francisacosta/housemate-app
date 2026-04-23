<?php

use App\Models\Profile;
use App\Models\ProfilePreference;
use App\Models\RoommatePost;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('browse posts page renders published roommate posts', function () {
    $user = User::factory()->create();

    $profile = Profile::factory()->for($user)->published()->create([
        'display_name' => 'Jamie Santos',
    ]);

    ProfilePreference::factory()->for($profile)->create([
        'cleanliness_level' => 'very_clean',
    ]);

    RoommatePost::factory()->for($user)->published()->create([
        'title' => 'Looking for one calm roommate to split a condo search',
        'post_type' => 'looking_for_roommates',
        'budget_min_centavos' => 800000,
        'budget_max_centavos' => 1200000,
    ]);

    $response = $this->get(route('posts.browse'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('public/Posts')
        ->has('posts', 1)
        ->where('posts.0.title', 'Looking for one calm roommate to split a condo search')
        ->where('posts.0.authorName', 'Jamie Santos')
        ->where('posts.0.postType', 'Looking For Roommates')
        ->where('posts.0.authorAvatarUrl', asset('default-profile-photo.svg')),
    );
});

test('roommate post details page renders published post data', function () {
    $user = User::factory()->create();

    $profile = Profile::factory()->for($user)->published()->create([
        'display_name' => 'Aly Cruz',
        'headline' => 'Remote worker looking for a tidy shared setup.',
    ]);

    ProfilePreference::factory()->for($profile)->create([
        'cleanliness_level' => 'very_clean',
        'pet_preference' => 'pet_friendly',
    ]);

    $post = RoommatePost::factory()->for($user)->published()->create([
        'title' => 'Open to joining a shared condo in a walkable area',
        'description' => 'I want a calm shared setup with clear expectations and a realistic move-in timeline.',
        'post_type' => 'looking_for_place',
    ]);

    $response = $this->get(route('posts.show', $post));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('public/PostShow')
        ->where('post.title', 'Open to joining a shared condo in a walkable area')
        ->where('post.author.name', 'Aly Cruz')
        ->where('post.author.headline', 'Remote worker looking for a tidy shared setup.')
        ->where('post.postType', 'Looking For Place')
        ->where('post.preferences.cleanliness', 'Very Clean')
        ->where('post.preferences.pets', 'Pet Friendly'),
    );
});

test('draft roommate post details page returns not found', function () {
    $post = RoommatePost::factory()->create([
        'status' => 'draft',
        'published_at' => null,
    ]);

    $response = $this->get(route('posts.show', $post));

    $response->assertNotFound();
});
