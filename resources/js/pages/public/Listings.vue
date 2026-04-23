<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicBrowseNav from '@/components/PublicBrowseNav.vue';
import { show } from '@/routes/listings';

type BrowseStat = {
    label: string;
    value: string;
};

type BrowseListing = {
    id: number;
    title: string;
    city: string;
    district: string | null;
    rent: string;
    availableFrom: string | null;
    propertyType: string;
    spaceType: string;
    description: string;
    hostName: string;
    coverPhotoUrl: string;
    photoCount: number;
    tags: string[];
};

const props = defineProps<{
    listings: BrowseListing[];
    stats: BrowseStat[];
    quickFilters: string[];
}>();

const accentByPropertyType: Record<string, string> = {
    Condo: 'from-[#eab77b] via-[#f6dfb1] to-[#fff8eb]',
    Apartment: 'from-[#accdb7] via-[#dff0df] to-[#f8fff7]',
    House: 'from-[#d7c1f6] via-[#efe5ff] to-[#faf7ff]',
    Bedspace: 'from-[#abc8ea] via-[#dbeafb] to-[#f4f8ff]',
};

const accentFor = (listing: BrowseListing): string =>
    accentByPropertyType[listing.propertyType] ??
    'from-[#f0be95] via-[#f9dfca] to-[#fff4ec]';

const locationLabel = (listing: BrowseListing): string =>
    listing.district ? `${listing.district}, ${listing.city}` : listing.city;
</script>

<template>
    <Head title="Browse Listings" />

    <div class="min-h-screen bg-[#f6f1e8] text-[#241c15]">
        <div class="absolute inset-x-0 top-0 -z-10 h-[28rem] bg-[radial-gradient(circle_at_top_left,_rgba(211,156,83,0.28),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(92,135,110,0.22),_transparent_32%),linear-gradient(180deg,_#f9f2e7_0%,_#f6f1e8_72%)]" />

        <PublicBrowseNav />

        <main class="px-6 pb-16 pt-10 lg:px-10">
            <section class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1.16fr_0.84fr] lg:items-end">
                <div class="space-y-6">
                    <div class="inline-flex items-center rounded-full border border-[#dac6a7] bg-[#fff6ea] px-3 py-1 text-xs font-semibold tracking-[0.18em] text-[#8a5e2f] uppercase">
                        Seeded Listing Feed
                    </div>

                    <div class="space-y-4">
                        <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-[#20170f] sm:text-5xl lg:text-6xl">
                            Real seeded listings, shaped into the browse experience.
                        </h1>
                        <p class="max-w-2xl text-base leading-7 text-[#655648] sm:text-lg">
                            This page now reads from the actual `listings` table. Search and filter controls are still visual for now, but every card below is backed by seeded data and links to a real details page.
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
                            <label for="listing-search" class="mb-2 block text-sm font-medium text-[#534436]">
                                Search listings
                            </label>
                            <input
                                id="listing-search"
                                type="text"
                                placeholder="Try Makati, Quezon City, furnished, private room..."
                                class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] placeholder:text-[#998471] focus:border-[#9f7a52] focus:outline-none"
                            />
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label for="city-filter" class="mb-2 block text-sm font-medium text-[#534436]">
                                    City
                                </label>
                                <select
                                    id="city-filter"
                                    class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] focus:border-[#9f7a52] focus:outline-none"
                                >
                                    <option>Any city</option>
                                    <option v-for="filter in props.quickFilters.filter((value) => !value.includes('PHP') && value !== 'Private room' && value !== 'Ready soon' && value !== 'Furnished')" :key="filter">
                                        {{ filter }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="rent-filter" class="mb-2 block text-sm font-medium text-[#534436]">
                                    Budget
                                </label>
                                <select
                                    id="rent-filter"
                                    class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] focus:border-[#9f7a52] focus:outline-none"
                                >
                                    <option>Any budget</option>
                                    <option>Under PHP 10k</option>
                                    <option>PHP 10k to 15k</option>
                                    <option>PHP 15k to 20k</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3">
                            <select
                                class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] focus:border-[#9f7a52] focus:outline-none"
                            >
                                <option>Property type</option>
                                <option>Condo</option>
                                <option>Apartment</option>
                                <option>House</option>
                                <option>Bedspace</option>
                            </select>
                            <select
                                class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] focus:border-[#9f7a52] focus:outline-none"
                            >
                                <option>Space type</option>
                                <option>Private Room</option>
                                <option>Shared Room</option>
                                <option>Entire Unit</option>
                            </select>
                            <input
                                type="text"
                                placeholder="Move-in date"
                                class="w-full rounded-2xl border border-[#d8c7b4] bg-white px-4 py-3 text-sm text-[#231a12] placeholder:text-[#998471] focus:border-[#9f7a52] focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto mt-8 max-w-7xl">
                <div class="flex flex-wrap items-center justify-between gap-4 rounded-[2rem] border border-[#d8cab8] bg-[#fffaf2] px-5 py-4 shadow-[0_12px_30px_rgba(77,53,31,0.06)]">
                    <div>
                        <p class="text-sm font-medium text-[#5b4b3e]">
                            {{ props.listings.length }} seeded listings available
                        </p>
                        <p class="text-sm text-[#897462]">
                            Search and filters are still static, but the result set and detail links are real.
                        </p>
                    </div>

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
            </section>

            <section class="mx-auto mt-8 max-w-7xl">
                <div v-if="props.listings.length > 0" class="grid gap-5 xl:grid-cols-2">
                    <article
                        v-for="listing in props.listings"
                        :key="listing.id"
                        class="group overflow-hidden rounded-[2rem] border border-[#d8cab7] bg-[#fffaf3] shadow-[0_18px_45px_rgba(77,53,31,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_55px_rgba(77,53,31,0.12)]"
                    >
                        <div class="grid lg:grid-cols-[0.44fr_0.56fr]">
                            <div class="relative min-h-64 overflow-hidden">
                                <img
                                    :src="listing.coverPhotoUrl"
                                    :alt="listing.title"
                                    class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-br opacity-60"
                                    :class="accentFor(listing)"
                                />
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.78),_transparent_22%),linear-gradient(160deg,_rgba(36,28,21,0.14),_transparent_60%)]" />

                                <div class="relative flex h-full flex-col justify-between p-5">
                                    <div class="flex items-start justify-between gap-3">
                                        <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold tracking-[0.15em] text-[#6e533b] uppercase backdrop-blur">
                                            {{ listing.propertyType }}
                                        </span>
                                        <span class="rounded-full border border-white/60 bg-white/30 px-3 py-1 text-xs font-medium text-[#4a392a] backdrop-blur">
                                            {{ listing.availableFrom ?? 'Move-in flexible' }}
                                        </span>
                                    </div>

                                    <div class="max-w-xs rounded-[1.5rem] bg-white/75 p-4 backdrop-blur">
                                        <p class="text-xs font-semibold tracking-[0.18em] text-[#815a38] uppercase">
                                            {{ locationLabel(listing) }}
                                        </p>
                                        <p class="mt-2 text-2xl font-semibold text-[#221911]">
                                            {{ listing.rent }}
                                        </p>
                                        <p class="mt-2 text-sm leading-6 text-[#5d4c3f]">
                                            {{ listing.photoCount }} seeded photo {{ listing.photoCount === 1 ? 'record' : 'records' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex h-full flex-col p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-[#8b7059]">
                                            {{ locationLabel(listing) }}
                                        </p>
                                        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-[#221911]">
                                            {{ listing.title }}
                                        </h2>
                                    </div>
                                    <span class="rounded-full bg-[#f1e4d4] px-3 py-1.5 text-xs font-semibold tracking-[0.14em] text-[#75583f] uppercase">
                                        {{ listing.spaceType }}
                                    </span>
                                </div>

                                <p class="mt-4 text-sm leading-7 text-[#5f5245]">
                                    {{ listing.description }}
                                </p>

                                <div class="mt-5 flex flex-wrap gap-2">
                                    <span
                                        v-for="tag in listing.tags"
                                        :key="tag"
                                        class="rounded-full border border-[#ddcfbe] px-3 py-1.5 text-sm text-[#655648]"
                                    >
                                        {{ tag }}
                                    </span>
                                </div>

                                <div class="mt-auto flex items-center justify-between gap-4 pt-6">
                                    <p class="text-sm text-[#8a7362]">
                                        Hosted by {{ listing.hostName }}
                                    </p>
                                    <Link
                                        :href="show(listing.id)"
                                        class="rounded-full bg-[#221911] px-4 py-2.5 text-sm font-medium text-[#fff9f2] transition hover:bg-[#3b2f24]"
                                    >
                                        View Listing
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>

                <div v-else class="rounded-[2rem] border border-dashed border-[#d7c5af] bg-[#fcf5ea] px-6 py-12 text-center">
                    <p class="text-sm font-semibold tracking-[0.16em] text-[#8a684c] uppercase">
                        No Listings Yet
                    </p>
                    <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#655648]">
                        Seed the database or publish a listing to populate this page.
                    </p>
                </div>
            </section>

            <section class="mx-auto mt-10 max-w-7xl">
                <div class="rounded-[2rem] border border-dashed border-[#d7c5af] bg-[#fcf5ea] px-6 py-8 text-center">
                    <p class="text-sm font-semibold tracking-[0.16em] text-[#8a684c] uppercase">
                        Next Build Step
                    </p>
                    <p class="mx-auto mt-3 max-w-2xl text-base leading-7 text-[#655648]">
                        The browse surface is now using real seeded records. The remaining work for this page is query-driven filtering and real media uploads.
                    </p>
                </div>
            </section>
        </main>
    </div>
</template>
