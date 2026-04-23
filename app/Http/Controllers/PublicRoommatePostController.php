<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\RoommatePost;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PublicRoommatePostController extends Controller
{
    public function index(): Response
    {
        $posts = RoommatePost::query()
            ->where('status', 'published')
            ->with(['user.profile.preference'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('public/Posts', [
            'posts' => $posts->map(fn (RoommatePost $post): array => $this->transformBrowsePost($post)),
            'stats' => $this->buildBrowseStats($posts),
            'quickFilters' => $this->buildQuickFilters($posts),
        ]);
    }

    public function show(RoommatePost $roommatePost): Response
    {
        abort_unless($roommatePost->status === 'published', HttpResponse::HTTP_NOT_FOUND);

        $roommatePost->load(['user.profile.preference']);

        $relatedPosts = RoommatePost::query()
            ->where('status', 'published')
            ->whereKeyNot($roommatePost->getKey())
            ->where('city_municipality', $roommatePost->city_municipality)
            ->with(['user.profile.preference'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return Inertia::render('public/PostShow', [
            'post' => $this->transformShowPost($roommatePost),
            'relatedPosts' => $relatedPosts->map(fn (RoommatePost $post): array => $this->transformBrowsePost($post)),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function transformBrowsePost(RoommatePost $post): array
    {
        $profile = $post->user->profile;
        $preference = $profile?->preference;

        return [
            'id' => $post->id,
            'title' => $post->title,
            'city' => $post->city_municipality,
            'district' => $post->district_or_barangay,
            'moveInDate' => $post->move_in_date?->format('M d, Y'),
            'budgetRange' => $this->formatBudgetRange($post->budget_min_centavos, $post->budget_max_centavos),
            'preferredPropertyType' => $post->preferred_property_type ? $this->labelize($post->preferred_property_type) : 'Flexible',
            'roommateIntent' => $this->labelize($post->roommate_intent),
            'postType' => $this->labelize($post->post_type),
            'description' => Str::squish(Str::limit($post->description, 180)),
            'authorName' => $profile?->display_name ?? $post->user->name,
            'authorAvatarUrl' => $profile?->avatarUrl() ?? Profile::defaultAvatarUrl(),
            'headline' => $profile?->headline,
            'tags' => array_values(array_filter([
                $preference?->cleanliness_level ? $this->labelize($preference->cleanliness_level) : null,
                $preference?->sleep_schedule ? $this->labelize($preference->sleep_schedule) : null,
                $preference?->pet_preference ? $this->labelize($preference->pet_preference) : null,
                $profile?->work_setup ? $this->labelize($profile->work_setup) : null,
            ])),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function transformShowPost(RoommatePost $post): array
    {
        $profile = $post->user->profile;
        $preference = $profile?->preference;

        return [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'postType' => $this->labelize($post->post_type),
            'roommateIntent' => $this->labelize($post->roommate_intent),
            'budgetRange' => $this->formatBudgetRange($post->budget_min_centavos, $post->budget_max_centavos),
            'moveInDate' => $post->move_in_date?->format('F j, Y'),
            'preferredPropertyType' => $post->preferred_property_type ? $this->labelize($post->preferred_property_type) : null,
            'location' => [
                'region' => $post->region,
                'province' => $post->province,
                'city' => $post->city_municipality,
                'district' => $post->district_or_barangay,
            ],
            'author' => [
                'name' => $profile?->display_name ?? $post->user->name,
                'avatarUrl' => $profile?->avatarUrl() ?? Profile::defaultAvatarUrl(),
                'headline' => $profile?->headline,
                'bio' => $profile?->bio,
                'occupation' => $profile?->occupation,
                'workSetup' => $profile?->work_setup ? $this->labelize($profile->work_setup) : null,
            ],
            'preferences' => [
                'cleanliness' => $this->nullableLabel($preference?->cleanliness_level),
                'smoking' => $this->nullableLabel($preference?->smoking_preference),
                'drinking' => $this->nullableLabel($preference?->drinking_preference),
                'pets' => $this->nullableLabel($preference?->pet_preference),
                'sleepSchedule' => $this->nullableLabel($preference?->sleep_schedule),
                'guestPolicy' => $this->nullableLabel($preference?->guest_policy),
                'noiseTolerance' => $this->nullableLabel($preference?->noise_tolerance),
                'cookingHabit' => $this->nullableLabel($preference?->cooking_habit),
                'workSchedule' => $this->nullableLabel($preference?->work_schedule),
                'canShareRoom' => $preference?->can_share_room,
                'preferredHousemateGender' => $this->nullableLabel($preference?->preferred_housemate_gender),
                'dealbreakers' => $preference?->dealbreakers_text,
                'householdRules' => $preference?->household_rules_text,
            ],
        ];
    }

    /**
     * @param  Collection<int, RoommatePost>  $posts
     * @return array<int, array{label: string, value: string}>
     */
    private function buildBrowseStats(Collection $posts): array
    {
        $groupSearchCount = $posts->where('post_type', 'forming_group')->count();
        $groupSearchShare = $posts->count() > 0
            ? (string) round(($groupSearchCount / $posts->count()) * 100).'%'
            : '0%';

        return [
            ['label' => 'Live posts', 'value' => (string) $posts->count()],
            ['label' => 'Cities covered', 'value' => (string) $posts->pluck('city_municipality')->unique()->count()],
            ['label' => 'Group-forming posts', 'value' => $groupSearchShare],
        ];
    }

    /**
     * @param  Collection<int, RoommatePost>  $posts
     * @return array<int, string>
     */
    private function buildQuickFilters(Collection $posts): array
    {
        $cities = $posts
            ->pluck('city_municipality')
            ->filter()
            ->unique()
            ->take(3)
            ->values()
            ->all();

        return array_values(array_filter([
            $cities[0] ?? null,
            'Under PHP 15k',
            'Looking for roommates',
            'Move soon',
            $posts->contains('preferred_property_type', 'condo') ? 'Condo' : null,
        ]));
    }

    private function labelize(string $value): string
    {
        return str($value)->replace('_', ' ')->title()->toString();
    }

    private function nullableLabel(?string $value): ?string
    {
        return $value ? $this->labelize($value) : null;
    }

    private function formatMoney(int $centavos): string
    {
        return 'PHP '.number_format($centavos / 100, 2);
    }

    private function formatBudgetRange(?int $minimumBudget, ?int $maximumBudget): string
    {
        if ($minimumBudget !== null && $maximumBudget !== null) {
            return $this->formatMoney($minimumBudget).' to '.$this->formatMoney($maximumBudget);
        }

        if ($minimumBudget !== null) {
            return 'From '.$this->formatMoney($minimumBudget);
        }

        if ($maximumBudget !== null) {
            return 'Up to '.$this->formatMoney($maximumBudget);
        }

        return 'Flexible budget';
    }
}
