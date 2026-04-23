<?php

use App\Models\Profile;
use App\Models\RoommatePost;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected from roommate post management pages', function () {
    $post = RoommatePost::factory()->create();

    $this->get(route('roommate-posts.index'))->assertRedirect(route('login'));
    $this->get(route('roommate-posts.create'))->assertRedirect(route('login'));
    $this->get(route('roommate-posts.edit', $post))->assertRedirect(route('login'));
});

test('authenticated users can view roommate post index and create pages', function () {
    $user = User::factory()->create();

    Profile::factory()->for($user)->published()->create([
        'region' => 'National Capital Region',
        'province' => 'Metro Manila',
        'city_municipality' => 'Makati',
        'district_or_barangay' => 'Poblacion',
        'budget_min_centavos' => 800000,
        'budget_max_centavos' => 1200000,
    ]);

    $this->actingAs($user);

    $this->get(route('roommate-posts.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('roommate-posts/Index'));

    $this->get(route('roommate-posts.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('roommate-posts/Edit')
            ->where('mode', 'create')
            ->where('post.cityMunicipality', 'Makati')
            ->where('post.budgetMin', 8000)
            ->where('post.budgetMax', 12000),
        );
});

test('authenticated users can create roommate posts', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post(route('roommate-posts.store'), [
            'title' => 'Looking for one quiet roommate near the city center',
            'description' => 'I want a calm shared setup with realistic house rules.',
            'status' => 'published',
            'post_type' => 'looking_for_roommates',
            'budget_min' => 8000,
            'budget_max' => 12000,
            'move_in_date' => '2026-06-01',
            'preferred_property_type' => 'condo',
            'region' => 'National Capital Region',
            'province' => 'Metro Manila',
            'city_municipality' => 'Makati',
            'district_or_barangay' => 'Poblacion',
            'roommate_intent' => 'looking_for_roommates',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('roommate-posts.index'));

    $post = RoommatePost::first();

    expect($post)->not->toBeNull();
    expect($post->user_id)->toBe($user->id);
    expect($post->title)->toBe('Looking for one quiet roommate near the city center');
    expect($post->status)->toBe('published');
    expect($post->budget_min_centavos)->toBe(800000);
    expect($post->budget_max_centavos)->toBe(1200000);
    expect($post->published_at)->not->toBeNull();
});

test('owners can update their roommate posts', function () {
    $user = User::factory()->create();
    $post = RoommatePost::factory()->for($user)->published()->create([
        'title' => 'Original title',
        'budget_min_centavos' => 700000,
        'budget_max_centavos' => 900000,
    ]);

    $response = $this
        ->actingAs($user)
        ->patch(route('roommate-posts.update', $post), [
            'title' => 'Updated title',
            'description' => 'Updated description with clearer expectations.',
            'status' => 'draft',
            'post_type' => 'forming_group',
            'budget_min' => 9000,
            'budget_max' => 14000,
            'move_in_date' => '2026-07-01',
            'preferred_property_type' => 'apartment',
            'region' => 'National Capital Region',
            'province' => 'Metro Manila',
            'city_municipality' => 'Taguig',
            'district_or_barangay' => 'Fort Bonifacio',
            'roommate_intent' => 'either',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('roommate-posts.index'));

    $post->refresh();

    expect($post->title)->toBe('Updated title');
    expect($post->status)->toBe('draft');
    expect($post->budget_min_centavos)->toBe(900000);
    expect($post->budget_max_centavos)->toBe(1400000);
    expect($post->published_at)->toBeNull();
});

test('users cannot edit roommate posts they do not own', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $post = RoommatePost::factory()->for($owner)->published()->create();

    $this->actingAs($intruder)
        ->get(route('roommate-posts.edit', $post))
        ->assertForbidden();

    $this->actingAs($intruder)
        ->patch(route('roommate-posts.update', $post), [
            'title' => 'Intrusion',
            'description' => 'Should not work.',
            'status' => 'draft',
            'post_type' => 'forming_group',
            'budget_min' => 6000,
            'budget_max' => 7000,
            'move_in_date' => '2026-08-01',
            'preferred_property_type' => 'house',
            'region' => 'National Capital Region',
            'province' => 'Metro Manila',
            'city_municipality' => 'Quezon City',
            'district_or_barangay' => 'Diliman',
            'roommate_intent' => 'either',
        ])
        ->assertForbidden();
});
