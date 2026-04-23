<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoommatePostRequest;
use App\Http\Requests\UpdateRoommatePostRequest;
use App\Models\Profile;
use App\Models\RoommatePost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoommatePostController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = $request->user()
            ->roommatePosts()
            ->latest('updated_at')
            ->latest('id')
            ->get();

        return Inertia::render('roommate-posts/Index', [
            'posts' => $posts->map(fn (RoommatePost $post): array => [
                'id' => $post->id,
                'title' => $post->title,
                'status' => str($post->status)->title()->toString(),
                'postType' => str($post->post_type)->replace('_', ' ')->title()->toString(),
                'city' => $post->city_municipality,
                'district' => $post->district_or_barangay,
                'budgetRange' => $this->formatBudgetRange($post->budget_min_centavos, $post->budget_max_centavos),
                'moveInDate' => $post->move_in_date?->format('M d, Y'),
                'updatedAt' => $post->updated_at?->diffForHumans(),
            ]),
        ]);
    }

    public function create(Request $request): Response
    {
        $profile = $request->user()->loadMissing('profile')->profile;

        return Inertia::render('roommate-posts/Edit', [
            'mode' => 'create',
            'post' => $this->postFormData(null, $profile),
            'options' => $this->formOptions(),
        ]);
    }

    public function store(StoreRoommatePostRequest $request): RedirectResponse
    {
        $request->user()->roommatePosts()->create($this->attributesForPersistence($request->validated()));

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Roommate post saved.')]);

        return to_route('roommate-posts.index');
    }

    public function edit(Request $request, RoommatePost $roommatePost): Response
    {
        abort_unless($request->user()->is($roommatePost->user), HttpResponse::HTTP_FORBIDDEN);

        return Inertia::render('roommate-posts/Edit', [
            'mode' => 'edit',
            'post' => $this->postFormData($roommatePost),
            'options' => $this->formOptions(),
        ]);
    }

    public function update(UpdateRoommatePostRequest $request, RoommatePost $roommatePost): RedirectResponse
    {
        $roommatePost->update($this->attributesForPersistence($request->validated(), $roommatePost));

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Roommate post updated.')]);

        return to_route('roommate-posts.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function postFormData(?RoommatePost $post = null, ?Profile $profile = null): array
    {
        return [
            'id' => $post?->id,
            'title' => $post?->title ?? '',
            'description' => $post?->description ?? '',
            'status' => $post?->status ?? 'draft',
            'postType' => $post?->post_type ?? 'looking_for_roommates',
            'budgetMin' => $post?->budget_min_centavos !== null
                ? (int) round($post->budget_min_centavos / 100)
                : ($profile?->budget_min_centavos !== null ? (int) round($profile->budget_min_centavos / 100) : null),
            'budgetMax' => $post?->budget_max_centavos !== null
                ? (int) round($post->budget_max_centavos / 100)
                : ($profile?->budget_max_centavos !== null ? (int) round($profile->budget_max_centavos / 100) : null),
            'moveInDate' => $post?->move_in_date?->format('Y-m-d') ?? $profile?->move_in_date?->format('Y-m-d'),
            'preferredPropertyType' => $post?->preferred_property_type ?? $profile?->preferred_property_type,
            'region' => $post?->region ?? $profile?->region ?? '',
            'province' => $post?->province ?? $profile?->province ?? '',
            'cityMunicipality' => $post?->city_municipality ?? $profile?->city_municipality ?? '',
            'districtOrBarangay' => $post?->district_or_barangay ?? $profile?->district_or_barangay,
            'roommateIntent' => $post?->roommate_intent ?? $profile?->roommate_intent ?? 'either',
        ];
    }

    /**
     * @return array<string, array<int, array{value: string, label: string}>>
     */
    private function formOptions(): array
    {
        return [
            'statuses' => [
                ['value' => 'draft', 'label' => 'Draft'],
                ['value' => 'published', 'label' => 'Published'],
            ],
            'postTypes' => [
                ['value' => 'looking_for_place', 'label' => 'Looking for place'],
                ['value' => 'looking_for_roommates', 'label' => 'Looking for roommates'],
                ['value' => 'forming_group', 'label' => 'Forming group'],
            ],
            'propertyTypes' => [
                ['value' => 'apartment', 'label' => 'Apartment'],
                ['value' => 'condo', 'label' => 'Condo'],
                ['value' => 'house', 'label' => 'House'],
                ['value' => 'bedspace', 'label' => 'Bedspace'],
            ],
            'roommateIntents' => [
                ['value' => 'looking_for_room', 'label' => 'Looking for room'],
                ['value' => 'looking_for_roommates', 'label' => 'Looking for roommates'],
                ['value' => 'either', 'label' => 'Either'],
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function attributesForPersistence(array $validated, ?RoommatePost $post = null): array
    {
        $isPublishing = $validated['status'] === 'published';

        return [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'post_type' => $validated['post_type'],
            'budget_min_centavos' => isset($validated['budget_min']) ? ((int) $validated['budget_min']) * 100 : null,
            'budget_max_centavos' => isset($validated['budget_max']) ? ((int) $validated['budget_max']) * 100 : null,
            'move_in_date' => $validated['move_in_date'] ?? null,
            'preferred_property_type' => $validated['preferred_property_type'] ?? null,
            'region' => $validated['region'],
            'province' => $validated['province'],
            'city_municipality' => $validated['city_municipality'],
            'district_or_barangay' => $validated['district_or_barangay'] ?? null,
            'roommate_intent' => $validated['roommate_intent'],
            'published_at' => $isPublishing
                ? ($post?->published_at ?? now())
                : null,
        ];
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
