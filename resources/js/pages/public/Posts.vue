<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicBrowseNav from '@/components/PublicBrowseNav.vue';
import { show } from '@/routes/posts';

type BrowseStat = {
    label: string;
    value: string;
};

type BrowsePost = {
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

const props = defineProps<{
    posts: BrowsePost[];
    stats: BrowseStat[];
    quickFilters: string[];
}>();

const accentByPostType: Record<string, string> = {
    'Looking For Place': 'from-[#eab77b] via-[#f6dfb1] to-[#fff8eb]',
    'Looking For Roommates': 'from-[#accdb7] via-[#dff0df] to-[#f8fff7]',
    'Forming Group': 'from-[#abc8ea] via-[#dbeafb] to-[#f4f8ff]',
};

const accentFor = (post: BrowsePost): string =>
    accentByPostType[post.postType] ??
    'from-[#f0be95] via-[#f9dfca] to-[#fff4ec]';

const locationLabel = (post: BrowsePost): string =>
    post.district ? `${post.district}, ${post.city}` : post.city;
</script>

<template>
    <Head title="Browse Posts" />

    <div class="min-h-screen bg-[#f6f1e8] text-[#241c15]">
        <div class="absolute inset-x-0 top-0 -z-10 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(211,156,83,0.28),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(92,135,110,0.22),_transparent_32%),linear-gradient(180deg,_#f9f2e7_0%,_#f6f1e8_72%)]" />

        <PublicBrowseNav />

        <main class="px-6 pb-16 pt-10 lg:px-10">
            <section class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1.16fr_0.84fr] lg:items-end">
                <div class="space-y-6">
                    <div class="inline-flex items-center rounded-full border border-[#dac6a7] bg-[#fff6ea] px-3 py-1 text-xs font-semibold tracking-[0.18em] text-[#8a5e2f] uppercase">
                        Seeded Roommate Posts
                    </div>

                    <div class="space-y-4">
                        <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-[#20170f] sm:text-5xl lg:text-6xl">
                            Real people looking for places, groups, and shared setups.
                        </h1>
                        <p class="max-w-2xl text-base leading-7 text-[#655648] sm:text-lg">
                            This page introduces the roommate-post side of Housemate. Each card below represents a real seeded post backed by the database and designed for people who want to find a place or form a group before renting.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div
                            v-for="stat in props.stats"
                            :key="stat.label"
                            class="rounded-3xl border border-[#d9cab7] bg-[#fffaf2] px-5 py-4 shadow-[0_10px_30px_rgba(77,53,31,0.05)]"
                        >
                            <p class="text-xs font-semibold tracking-[0.16em] text-[#876650] uppercase">
                                {{ stat.label }}
                            </p>
                            <p class="mt-2 text-3xl font-semibold text-[#231a12]">
                                {{ stat.value }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-[#dac9b6] bg-[#fffaf2] p-5 shadow-[0_24px_60px_rgba(77,53,31,0.12)]">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold tracking-[0.16em] text-[#876650] uppercase">
                                Browse Rhythm
                            </p>
                            <h2 class="mt-2 text-2xl font-semibold text-[#231a12]">
                                Roommate intent first, profile details after.
                            </h2>
                        </div>
                        <p class="text-sm leading-7 text-[#655648]">
                            The public surface focuses on practical intent: budget, timing, area, and household fit. Full profiles can still support matching later, but the first browse experience stays anchored to posts.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="filter in props.quickFilters"
                                :key="filter"
                                class="rounded-full border border-[#d4c3ae] bg-[#f7eddf] px-3 py-1.5 text-sm text-[#6c5847]"
                            >
                                {{ filter }}
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto mt-8 max-w-7xl">
                <div v-if="props.posts.length > 0" class="grid gap-5 xl:grid-cols-2">
                    <article
                        v-for="post in props.posts"
                        :key="post.id"
                        class="group overflow-hidden rounded-[2rem] border border-[#d8cab7] bg-[#fffaf3] shadow-[0_18px_45px_rgba(77,53,31,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_55px_rgba(77,53,31,0.12)]"
                    >
                        <div class="relative overflow-hidden border-b border-[#eadfce] px-6 py-6">
                            <div class="absolute inset-0 bg-gradient-to-br opacity-60" :class="accentFor(post)" />
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.82),_transparent_22%),linear-gradient(160deg,_rgba(36,28,21,0.1),_transparent_60%)]" />

                            <div class="relative flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <img
                                        :src="post.authorAvatarUrl"
                                        :alt="post.authorName"
                                        class="h-14 w-14 rounded-2xl border border-white/60 bg-white/70 object-cover shadow-[0_10px_24px_rgba(77,53,31,0.08)]"
                                    />
                                    <div>
                                        <p class="text-sm font-medium text-[#75583f]">
                                            {{ post.authorName }}
                                        </p>
                                        <p v-if="post.headline" class="mt-1 max-w-md text-sm leading-6 text-[#5f5245]">
                                            {{ post.headline }}
                                        </p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold tracking-[0.15em] text-[#6e533b] uppercase backdrop-blur">
                                    {{ post.postType }}
                                </span>
                            </div>
                        </div>

                        <div class="flex h-full flex-col p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-[#8b7059]">
                                        {{ locationLabel(post) }}
                                    </p>
                                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-[#221911]">
                                        {{ post.title }}
                                    </h2>
                                </div>
                                <span class="rounded-full bg-[#f1e4d4] px-3 py-1.5 text-xs font-semibold tracking-[0.14em] text-[#75583f] uppercase">
                                    {{ post.preferredPropertyType }}
                                </span>
                            </div>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-[1.4rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                    <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                                        Budget range
                                    </p>
                                    <p class="mt-2 text-lg font-semibold text-[#231a12]">
                                        {{ post.budgetRange }}
                                    </p>
                                </div>
                                <div class="rounded-[1.4rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                    <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                                        Move-in timing
                                    </p>
                                    <p class="mt-2 text-lg font-semibold text-[#231a12]">
                                        {{ post.moveInDate ?? 'Flexible' }}
                                    </p>
                                </div>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-[#5f5245]">
                                {{ post.description }}
                            </p>

                            <div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="rounded-full border border-[#ddcfbe] px-3 py-1.5 text-sm text-[#655648]"
                                >
                                    {{ post.roommateIntent }}
                                </span>
                                <span
                                    v-for="tag in post.tags"
                                    :key="tag"
                                    class="rounded-full border border-[#ddcfbe] px-3 py-1.5 text-sm text-[#655648]"
                                >
                                    {{ tag }}
                                </span>
                            </div>

                            <div class="mt-6 flex items-center justify-between gap-4 border-t border-[#eadfce] pt-5">
                                <p class="text-sm text-[#6f6257]">
                                    Built for people who want fit before messaging.
                                </p>
                                <Link
                                    :href="show(post.id)"
                                    class="rounded-full bg-[#221911] px-4 py-2.5 text-sm font-medium text-[#fff9f2] transition hover:bg-[#3b2f24]"
                                >
                                    View Post
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>

                <div
                    v-else
                    class="rounded-[2rem] border border-dashed border-[#d8cab7] bg-[#fffaf2] px-6 py-14 text-center text-[#6c5c4d]"
                >
                    No roommate posts are live yet.
                </div>
            </section>
        </main>
    </div>
</template>
