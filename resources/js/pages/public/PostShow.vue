<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicBrowseNav from '@/components/PublicBrowseNav.vue';
import { browse, show } from '@/routes/posts';

type RelatedPost = {
    id: number;
    title: string;
    city: string;
    district: string | null;
    moveInDate: string | null;
    budgetRange: string;
    preferredPropertyType: string;
    roommateIntent: string;
    postType: string;
    description: string;
    authorName: string;
    authorAvatarUrl: string;
    headline: string | null;
    tags: string[];
};

type PostDetails = {
    id: number;
    title: string;
    description: string;
    postType: string;
    roommateIntent: string;
    budgetRange: string;
    moveInDate: string | null;
    preferredPropertyType: string | null;
    location: {
        region: string;
        province: string;
        city: string;
        district: string | null;
    };
    author: {
        name: string;
        avatarUrl: string;
        headline: string | null;
        bio: string | null;
        occupation: string | null;
        workSetup: string | null;
    };
    preferences: {
        cleanliness: string | null;
        smoking: string | null;
        drinking: string | null;
        pets: string | null;
        sleepSchedule: string | null;
        guestPolicy: string | null;
        noiseTolerance: string | null;
        cookingHabit: string | null;
        workSchedule: string | null;
        canShareRoom: boolean | null;
        preferredHousemateGender: string | null;
        dealbreakers: string | null;
        householdRules: string | null;
    };
};

const props = defineProps<{
    post: PostDetails;
    relatedPosts: RelatedPost[];
}>();

const detailChips = computed(() =>
    [
        props.post.postType,
        props.post.roommateIntent,
        props.post.preferredPropertyType,
        props.post.preferences.canShareRoom === true ? 'Can share room' : null,
        props.post.preferences.preferredHousemateGender,
    ].filter(Boolean) as string[],
);

const detailRows = computed(() => [
    {
        label: 'Budget range',
        value: props.post.budgetRange,
    },
    {
        label: 'Move-in timing',
        value: props.post.moveInDate ?? 'Flexible',
    },
    {
        label: 'Preferred property',
        value: props.post.preferredPropertyType ?? 'Flexible',
    },
    {
        label: 'Target area',
        value: props.post.location.district
            ? `${props.post.location.district}, ${props.post.location.city}`
            : props.post.location.city,
    },
]);

const preferenceRows = computed(() => [
    { label: 'Cleanliness', value: props.post.preferences.cleanliness },
    { label: 'Smoking', value: props.post.preferences.smoking },
    { label: 'Drinking', value: props.post.preferences.drinking },
    { label: 'Pets', value: props.post.preferences.pets },
    { label: 'Sleep schedule', value: props.post.preferences.sleepSchedule },
    { label: 'Guest policy', value: props.post.preferences.guestPolicy },
    { label: 'Noise tolerance', value: props.post.preferences.noiseTolerance },
    { label: 'Cooking habit', value: props.post.preferences.cookingHabit },
    { label: 'Work schedule', value: props.post.preferences.workSchedule },
].filter((row) => row.value));
</script>

<template>
    <Head :title="post.title" />

    <div class="min-h-screen bg-[#f6f1e8] text-[#241c15]">
        <div class="absolute inset-x-0 top-0 -z-10 h-[26rem] bg-[radial-gradient(circle_at_top_left,_rgba(211,156,83,0.24),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(92,135,110,0.2),_transparent_30%),linear-gradient(180deg,_#f9f2e7_0%,_#f6f1e8_72%)]" />

        <PublicBrowseNav />

        <main class="px-6 pb-16 pt-8 lg:px-10">
            <section class="mx-auto max-w-7xl">
                <Link
                    :href="browse()"
                    class="inline-flex items-center rounded-full border border-[#d8cab8] bg-[#fffaf2] px-4 py-2 text-sm font-medium text-[#5b4b3e] shadow-[0_10px_24px_rgba(77,53,31,0.05)] transition hover:bg-[#f3e8d9]"
                >
                    Back to posts
                </Link>
            </section>

            <section class="mx-auto mt-6 grid max-w-7xl gap-8 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="space-y-4">
                    <div class="overflow-hidden rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] shadow-[0_22px_56px_rgba(77,53,31,0.09)]">
                        <div class="relative overflow-hidden p-6 md:p-8">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.82),_transparent_20%),linear-gradient(150deg,_rgba(36,28,21,0.06),_transparent_62%),linear-gradient(135deg,_#f3c78b_0%,_#f5e1b8_45%,_#fff7e8_100%)]" />
                            <div class="relative space-y-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <img
                                            :src="props.post.author.avatarUrl"
                                            :alt="props.post.author.name"
                                            class="h-16 w-16 rounded-2xl border border-white/60 bg-white/70 object-cover shadow-[0_10px_24px_rgba(77,53,31,0.08)]"
                                        />
                                        <div>
                                            <p class="text-sm font-medium text-[#8b7059]">
                                                {{ props.post.author.name }}
                                            </p>
                                            <p v-if="props.post.author.headline" class="mt-1 max-w-xl text-sm leading-6 text-[#5f5245]">
                                                {{ props.post.author.headline }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold tracking-[0.15em] text-[#6e533b] uppercase backdrop-blur">
                                        {{ props.post.postType }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-[#8b7059]">
                                        {{ props.post.location.district ? `${props.post.location.district}, ${props.post.location.city}` : props.post.location.city }}
                                    </p>
                                    <h1 class="mt-2 max-w-3xl text-4xl font-semibold tracking-tight text-[#20170f]">
                                        {{ props.post.title }}
                                    </h1>
                                    <p class="mt-3 max-w-3xl text-base leading-7 text-[#655648]">
                                        {{ props.post.description }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="chip in detailChips"
                                        :key="chip"
                                        class="rounded-full border border-[#ddcfbe] bg-[#fffaf2] px-3 py-1.5 text-sm text-[#655648]"
                                    >
                                        {{ chip }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_22px_56px_rgba(77,53,31,0.09)]">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div
                                v-for="row in detailRows"
                                :key="row.label"
                                class="rounded-[1.4rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4"
                            >
                                <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                                    {{ row.label }}
                                </p>
                                <p class="mt-2 text-lg font-semibold text-[#231a12]">
                                    {{ row.value }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center gap-3 pt-1">
                            <button
                                type="button"
                                class="rounded-full bg-[#221911] px-5 py-3 text-sm font-medium text-[#fff9f2] transition hover:bg-[#3b2f24]"
                            >
                                Express Interest
                            </button>
                            <button
                                type="button"
                                class="rounded-full border border-[#d4c3ae] bg-[#fffaf2] px-5 py-3 text-sm font-medium text-[#4d3b2d] transition hover:bg-[#f3e8d9]"
                            >
                                Save For Later
                            </button>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_20px_48px_rgba(77,53,31,0.07)]">
                        <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                            Author Summary
                        </p>
                        <div class="mt-4 space-y-3">
                            <h2 class="text-2xl font-semibold text-[#221911]">
                                {{ props.post.author.name }}
                            </h2>
                            <p v-if="props.post.author.headline" class="text-sm font-medium text-[#6b5848]">
                                {{ props.post.author.headline }}
                            </p>
                            <p v-if="props.post.author.bio" class="text-sm leading-7 text-[#655648]">
                                {{ props.post.author.bio }}
                            </p>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Occupation
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ props.post.author.occupation ?? 'Not specified' }}
                                </p>
                            </div>
                            <div class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Work setup
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ props.post.author.workSetup ?? 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_20px_48px_rgba(77,53,31,0.07)]">
                        <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                            Household Preferences
                        </p>

                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div
                                v-for="preference in preferenceRows"
                                :key="preference.label"
                                class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4"
                            >
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    {{ preference.label }}
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ preference.value }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4">
                            <div v-if="props.post.preferences.householdRules" class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Household rules
                                </p>
                                <p class="mt-2 text-sm leading-7 text-[#231a12]">
                                    {{ props.post.preferences.householdRules }}
                                </p>
                            </div>
                            <div v-if="props.post.preferences.dealbreakers" class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Dealbreakers
                                </p>
                                <p class="mt-2 text-sm leading-7 text-[#231a12]">
                                    {{ props.post.preferences.dealbreakers }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto mt-10 max-w-7xl">
                <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_20px_48px_rgba(77,53,31,0.07)]">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                                More Posts
                            </p>
                            <h2 class="mt-2 text-2xl font-semibold text-[#221911]">
                                Nearby roommate intent
                            </h2>
                        </div>
                        <Link
                            :href="browse()"
                            class="rounded-full border border-[#d4c3ae] bg-[#fffaf2] px-4 py-2.5 text-sm font-medium text-[#4d3b2d] transition hover:bg-[#f3e8d9]"
                        >
                            Back to browse
                        </Link>
                    </div>

                    <div class="mt-6 grid gap-4 lg:grid-cols-3">
                        <Link
                            v-for="relatedPost in props.relatedPosts"
                            :key="relatedPost.id"
                            :href="show(relatedPost.id)"
                            class="rounded-[1.6rem] border border-[#e4d8c8] bg-[#fffdf8] p-5 transition hover:-translate-y-1 hover:shadow-[0_18px_40px_rgba(77,53,31,0.08)]"
                        >
                            <div class="flex items-center gap-3">
                                <img
                                    :src="relatedPost.authorAvatarUrl"
                                    :alt="relatedPost.authorName"
                                    class="h-10 w-10 rounded-xl border border-[#e4d8c8] bg-[#f8f1e5] object-cover"
                                />
                                <div>
                                    <p class="text-sm font-medium text-[#8b7059]">
                                        {{ relatedPost.authorName }}
                                    </p>
                                    <p class="text-xs text-[#6f6257]">
                                        {{ relatedPost.postType }}
                                    </p>
                                </div>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-[#221911]">
                                {{ relatedPost.title }}
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-[#655648]">
                                {{ relatedPost.description }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="rounded-full border border-[#ddcfbe] px-3 py-1.5 text-sm text-[#655648]">
                                    {{ relatedPost.budgetRange }}
                                </span>
                            </div>
                        </Link>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
