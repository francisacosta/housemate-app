<?php

use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('browse listings page renders published listings', function () {
    $user = User::factory()->create();
    Profile::factory()->for($user)->published()->create([
        'display_name' => 'Test Host',
    ]);

    $listing = Listing::factory()->for($user)->published()->create([
        'title' => 'Quiet room near transit',
    ]);

    ListingPhoto::factory()->for($listing)->create([
        'is_cover' => true,
        'sort_order' => 0,
    ]);

    $response = $this->get(route('listings.browse'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('public/Listings')
        ->has('listings', 1)
        ->where('listings.0.title', 'Quiet room near transit')
        ->where('listings.0.hostName', 'Test Host')
        ->where('listings.0.coverPhotoUrl', asset('default-listing-photo.svg')),
    );
});

test('listing details page renders published listing data', function () {
    $user = User::factory()->create();
    Profile::factory()->for($user)->published()->create([
        'display_name' => 'Test Host',
        'headline' => 'Clean and quiet roommate profile',
    ]);

    $listing = Listing::factory()->for($user)->published()->create([
        'title' => 'Furnished room in Makati',
        'description' => 'Spacious seeded description for the listing details page.',
    ]);

    ListingPhoto::factory()->for($listing)->create([
        'is_cover' => true,
        'sort_order' => 0,
    ]);

    $response = $this->get(route('listings.show', $listing));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('public/ListingShow')
        ->where('listing.title', 'Furnished room in Makati')
        ->where('listing.host.name', 'Test Host')
        ->where('listing.host.headline', 'Clean and quiet roommate profile')
        ->where('listing.host.avatarUrl', asset('default-profile-photo.svg'))
        ->where('listing.photos', []),
    );
});

test('listing details page exposes stored public photo urls', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    Profile::factory()->for($user)->published()->create();

    $listing = Listing::factory()->for($user)->published()->create();

    Storage::disk('public')->put('listing-photos/test-cover.jpg', 'fake-image');

    ListingPhoto::factory()->for($listing)->create([
        'storage_path' => 'listing-photos/test-cover.jpg',
        'is_cover' => true,
        'sort_order' => 0,
    ]);

    $response = $this->get(route('listings.show', $listing));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('public/ListingShow')
        ->where('listing.photos.0.url', Storage::disk('public')->url('listing-photos/test-cover.jpg')),
    );
});

test('profile settings page shares a default avatar when no profile photo exists', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('profile.edit'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('settings/Profile')
        ->where('auth.user.avatar', asset('default-profile-photo.svg')),
    );
});

test('draft listing details page returns not found', function () {
    $listing = Listing::factory()->create([
        'status' => 'draft',
        'published_at' => null,
    ]);

    $response = $this->get(route('listings.show', $listing));

    $response->assertNotFound();
});
