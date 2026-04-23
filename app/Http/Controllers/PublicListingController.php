<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingPhoto;
use App\Models\Profile;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PublicListingController extends Controller
{
    public function index(): Response
    {
        $listings = Listing::query()
            ->where('status', 'published')
            ->with(['photos', 'user.profile'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('public/Listings', [
            'listings' => $listings->map(fn (Listing $listing): array => $this->transformBrowseListing($listing)),
            'stats' => $this->buildBrowseStats($listings),
            'quickFilters' => $this->buildQuickFilters($listings),
        ]);
    }

    public function show(Listing $listing): Response
    {
        abort_unless($listing->status === 'published', HttpResponse::HTTP_NOT_FOUND);

        $listing->load(['photos', 'user.profile']);

        $relatedListings = Listing::query()
            ->where('status', 'published')
            ->whereKeyNot($listing->getKey())
            ->with(['photos', 'user.profile'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return Inertia::render('public/ListingShow', [
            'listing' => $this->transformShowListing($listing),
            'relatedListings' => $relatedListings->map(fn (Listing $relatedListing): array => $this->transformBrowseListing($relatedListing)),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function transformBrowseListing(Listing $listing): array
    {
        $hostName = $listing->user->profile?->display_name ?? $listing->user->name;

        return [
            'id' => $listing->id,
            'title' => $listing->title,
            'city' => $listing->city_municipality,
            'district' => $listing->district_or_barangay,
            'rent' => $this->formatMoney($listing->monthly_rent_centavos),
            'availableFrom' => $listing->available_from?->format('M d, Y'),
            'propertyType' => $this->labelize($listing->property_type),
            'spaceType' => $this->labelize($listing->space_type),
            'description' => Str::squish(Str::limit($listing->description, 180)),
            'hostName' => $hostName,
            'coverPhotoUrl' => $listing->coverPhotoUrl(),
            'photoCount' => $listing->photos->count(),
            'tags' => array_values(array_filter([
                $listing->furnished ? 'Furnished' : 'Unfurnished',
                $listing->utilities_included ? 'Utilities included' : 'Utilities split',
                $listing->available_slots > 1 ? "{$listing->available_slots} slots open" : '1 slot open',
                $listing->allows_pets === true ? 'Pets allowed' : null,
                $listing->allows_smoking === false ? 'No smoking' : null,
            ])),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformShowListing(Listing $listing): array
    {
        $profile = $listing->user->profile;
        $photos = $listing->displayPhotos();

        return [
            'id' => $listing->id,
            'title' => $listing->title,
            'description' => $listing->description,
            'rent' => $this->formatMoney($listing->monthly_rent_centavos),
            'deposit' => $listing->deposit_centavos !== null ? $this->formatMoney($listing->deposit_centavos) : null,
            'availableFrom' => $listing->available_from?->format('F j, Y'),
            'minimumStayMonths' => $listing->minimum_stay_months,
            'propertyType' => $this->labelize($listing->property_type),
            'spaceType' => $this->labelize($listing->space_type),
            'location' => [
                'region' => $listing->region,
                'province' => $listing->province,
                'city' => $listing->city_municipality,
                'district' => $listing->district_or_barangay,
            ],
            'furnished' => $listing->furnished,
            'utilitiesIncluded' => $listing->utilities_included,
            'availableSlots' => $listing->available_slots,
            'currentOccupants' => $listing->current_occupants,
            'preferredTenantGender' => $listing->preferred_tenant_gender ? $this->labelize($listing->preferred_tenant_gender) : null,
            'allowsSmoking' => $listing->allows_smoking,
            'allowsPets' => $listing->allows_pets,
            'photos' => $photos
                ->values()
                ->map(fn (ListingPhoto $photo): array => [
                    'id' => $photo->id,
                    'label' => $photo->is_cover ? 'Cover photo' : 'Photo '.($photo->sort_order + 1),
                    'sortOrder' => $photo->sort_order,
                    'isCover' => $photo->is_cover,
                    'storagePath' => $photo->storage_path,
                    'url' => $photo->publicUrl(),
                ])
                ->all(),
            'host' => [
                'name' => $profile?->display_name ?? $listing->user->name,
                'avatarUrl' => $profile?->avatarUrl() ?? Profile::defaultAvatarUrl(),
                'headline' => $profile?->headline,
                'occupation' => $profile?->occupation,
                'bio' => $profile?->bio,
                'workSetup' => $profile?->work_setup ? $this->labelize($profile->work_setup) : null,
                'budgetRange' => $profile?->budget_min_centavos !== null && $profile?->budget_max_centavos !== null
                    ? $this->formatMoney($profile->budget_min_centavos).' to '.$this->formatMoney($profile->budget_max_centavos)
                    : null,
            ],
        ];
    }

    /**
     * @param  Collection<int, Listing>  $listings
     * @return array<int, array{label: string, value: string}>
     */
    private function buildBrowseStats(Collection $listings): array
    {
        $privateRoomCount = $listings->where('space_type', 'private_room')->count();
        $privateRoomShare = $listings->count() > 0
            ? (string) round(($privateRoomCount / $listings->count()) * 100).'%'
            : '0%';

        return [
            ['label' => 'Live listings', 'value' => (string) $listings->count()],
            ['label' => 'Cities covered', 'value' => (string) $listings->pluck('city_municipality')->unique()->count()],
            ['label' => 'Private rooms', 'value' => $privateRoomShare],
        ];
    }

    /**
     * @param  Collection<int, Listing>  $listings
     * @return array<int, string>
     */
    private function buildQuickFilters(Collection $listings): array
    {
        $cities = $listings
            ->pluck('city_municipality')
            ->filter()
            ->unique()
            ->take(3)
            ->values()
            ->all();

        return array_values(array_filter([
            $cities[0] ?? null,
            'Under PHP 15k',
            'Private room',
            'Ready soon',
            $listings->contains('furnished', true) ? 'Furnished' : null,
        ]));
    }

    private function labelize(string $value): string
    {
        return str($value)->replace('_', ' ')->title()->toString();
    }

    private function formatMoney(int $centavos): string
    {
        return 'PHP '.number_format($centavos / 100, 2);
    }
}
