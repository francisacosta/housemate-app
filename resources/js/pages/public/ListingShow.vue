<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicBrowseNav from '@/components/PublicBrowseNav.vue';
import { browse, show } from '@/routes/listings';

type ListingPhoto = {
    id: number;
    label: string;
    sortOrder: number;
    isCover: boolean;
    storagePath: string;
    url: string;
};

type RelatedListing = {
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

type ListingDetails = {
    id: number;
    title: string;
    description: string;
    rent: string;
    deposit: string | null;
    availableFrom: string | null;
    minimumStayMonths: number | null;
    propertyType: string;
    spaceType: string;
    location: {
        region: string;
        province: string;
        city: string;
        district: string | null;
    };
    furnished: boolean;
    utilitiesIncluded: boolean;
    availableSlots: number;
    currentOccupants: number | null;
    preferredTenantGender: string | null;
    allowsSmoking: boolean | null;
    allowsPets: boolean | null;
    photos: ListingPhoto[];
    host: {
        name: string;
        avatarUrl: string;
        headline: string | null;
        occupation: string | null;
        bio: string | null;
        workSetup: string | null;
        budgetRange: string | null;
    };
};

const props = defineProps<{
    listing: ListingDetails;
    relatedListings: RelatedListing[];
}>();

const mediaTones = [
    'from-[#f3c78b] via-[#f5e1b8] to-[#fff7e8]',
    'from-[#b7d7c2] via-[#dff0df] to-[#f8fff7]',
    'from-[#d6c1f7] via-[#efe7ff] to-[#faf8ff]',
    'from-[#adc7eb] via-[#dbe9fb] to-[#f4f8ff]',
];

const defaultListingPhotoUrl = '/default-listing-photo.svg';

const mediaItems = computed(() =>
    props.listing.photos.length > 0
        ? props.listing.photos
        : [
              {
                  id: 0,
                  label: 'Preview',
                  sortOrder: 0,
                  isCover: true,
                  storagePath: '',
                  url: defaultListingPhotoUrl,
              },
          ],
);

const detailChips = computed(() =>
    [
        props.listing.furnished ? 'Furnished' : 'Unfurnished',
        props.listing.utilitiesIncluded ? 'Utilities included' : 'Utilities split',
        props.listing.currentOccupants !== null
            ? `${props.listing.currentOccupants} current occupants`
            : null,
        props.listing.preferredTenantGender,
        props.listing.allowsPets === true
            ? 'Pets allowed'
            : props.listing.allowsPets === false
              ? 'No pets'
              : null,
        props.listing.allowsSmoking === true
            ? 'Smoking allowed'
            : props.listing.allowsSmoking === false
              ? 'No smoking'
              : null,
    ].filter(Boolean) as string[],
);

const detailRows = computed(() => [
    {
        label: 'Monthly rent',
        value: props.listing.rent,
    },
    {
        label: 'Deposit',
        value: props.listing.deposit ?? 'Not specified',
    },
    {
        label: 'Available from',
        value: props.listing.availableFrom ?? 'Flexible',
    },
    {
        label: 'Minimum stay',
        value: props.listing.minimumStayMonths
            ? `${props.listing.minimumStayMonths} months`
            : 'Not specified',
    },
    {
        label: 'Property type',
        value: props.listing.propertyType,
    },
    {
        label: 'Space type',
        value: props.listing.spaceType,
    },
    {
        label: 'Open slots',
        value: `${props.listing.availableSlots}`,
    },
    {
        label: 'Location',
        value: props.listing.location.district
            ? `${props.listing.location.district}, ${props.listing.location.city}`
            : props.listing.location.city,
    },
]);
</script>

<template>
    <Head :title="props.listing.title" />

    <div class="min-h-screen bg-[#f6f1e8] text-[#241c15]">
        <div class="absolute inset-x-0 top-0 -z-10 h-[30rem] bg-[radial-gradient(circle_at_top_left,_rgba(211,156,83,0.28),_transparent_36%),radial-gradient(circle_at_top_right,_rgba(92,135,110,0.2),_transparent_32%),linear-gradient(180deg,_#f9f2e7_0%,_#f6f1e8_72%)]" />

        <PublicBrowseNav />

        <main class="px-6 pb-16 pt-8 lg:px-10">
            <section class="mx-auto max-w-7xl">
                <Link
                    :href="browse()"
                    class="inline-flex items-center rounded-full border border-[#d8cab8] bg-[#fffaf2] px-4 py-2 text-sm font-medium text-[#5b4b3e] shadow-[0_10px_24px_rgba(77,53,31,0.05)] transition hover:bg-[#f3e8d9]"
                >
                    Back to listings
                </Link>
            </section>

            <section class="mx-auto mt-6 grid max-w-7xl gap-8 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="space-y-4">
                    <div class="overflow-hidden rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] shadow-[0_22px_56px_rgba(77,53,31,0.09)]">
                        <div class="grid gap-3 p-3 md:grid-cols-[1.2fr_0.8fr]">
                            <div class="relative min-h-80 overflow-hidden rounded-[1.5rem]">
                                <img
                                    :src="mediaItems[0].url"
                                    :alt="props.listing.title"
                                    class="absolute inset-0 h-full w-full object-cover"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-br opacity-60"
                                    :class="mediaTones[0]"
                                />
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.82),_transparent_20%),linear-gradient(150deg,_rgba(36,28,21,0.18),_transparent_62%)]" />
                                <div class="relative flex h-full flex-col justify-between p-6">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold tracking-[0.15em] text-[#6e533b] uppercase backdrop-blur">
                                            {{ props.listing.propertyType }}
                                        </span>
                                        <span class="rounded-full border border-white/60 bg-white/35 px-3 py-1 text-xs font-medium text-[#4a392a] backdrop-blur">
                                            {{ mediaItems[0].label }}
                                        </span>
                                    </div>

                                    <div class="max-w-xs rounded-[1.5rem] bg-white/75 p-4 backdrop-blur">
                                        <p class="text-xs font-semibold tracking-[0.16em] text-[#815a38] uppercase">
                                            {{ props.listing.location.city }}
                                        </p>
                                        <p class="mt-2 text-2xl font-semibold text-[#221911]">
                                            {{ props.listing.rent }}
                                        </p>
                                        <p class="mt-2 text-sm leading-6 text-[#5d4c3f]">
                                            {{ props.listing.location.district ?? props.listing.location.province }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-3">
                                <div
                                    v-for="(photo, index) in mediaItems.slice(1, 4)"
                                    :key="photo.id"
                                    class="relative min-h-24 overflow-hidden rounded-[1.4rem] border border-[#e4d8c8]"
                                >
                                    <img
                                        :src="photo.url"
                                        :alt="photo.label"
                                        class="absolute inset-0 h-full w-full object-cover"
                                    />
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br opacity-55"
                                        :class="mediaTones[(index + 1) % mediaTones.length]"
                                    />
                                    <div class="absolute inset-0 bg-[linear-gradient(160deg,_rgba(255,255,255,0.58),_transparent_35%),linear-gradient(160deg,_rgba(36,28,21,0.18),_transparent_60%)]" />
                                    <div class="relative flex h-full items-end p-4">
                                        <div class="rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-[#56473a] backdrop-blur">
                                            {{ photo.label }}
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="mediaItems.length === 1"
                                    class="flex min-h-24 items-center justify-center rounded-[1.4rem] border border-dashed border-[#d9cab7] bg-[#f8f1e5] p-4 text-center text-sm text-[#826d5c]"
                                >
                                    Media records can be attached once upload storage is wired.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_22px_56px_rgba(77,53,31,0.09)]">
                        <div class="space-y-4">
                            <div class="inline-flex items-center rounded-full border border-[#dac6a7] bg-[#fff6ea] px-3 py-1 text-xs font-semibold tracking-[0.18em] text-[#8a5e2f] uppercase">
                                Real Seeded Record
                            </div>

                            <div>
                                <p class="text-sm font-medium text-[#8b7059]">
                                    {{ props.listing.location.district ? `${props.listing.location.district}, ${props.listing.location.city}` : props.listing.location.city }}
                                </p>
                                <h1 class="mt-2 text-4xl font-semibold tracking-tight text-[#20170f]">
                                    {{ props.listing.title }}
                                </h1>
                                <p class="mt-3 max-w-2xl text-base leading-7 text-[#655648]">
                                    {{ props.listing.description }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="chip in detailChips"
                                    :key="chip"
                                    class="rounded-full border border-[#ddcfbe] bg-[#f7eddf] px-3 py-1.5 text-sm text-[#655648]"
                                >
                                    {{ chip }}
                                </span>
                            </div>

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

                            <div class="flex flex-wrap items-center gap-3 pt-1">
                                <button
                                    type="button"
                                    class="rounded-full bg-[#221911] px-5 py-3 text-sm font-medium text-[#fff9f2] transition hover:bg-[#3b2f24]"
                                >
                                    Inquire About Listing
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

                    <div class="rounded-[2rem] border border-[#d8cab7] bg-[#fffaf2] p-6 shadow-[0_20px_48px_rgba(77,53,31,0.07)]">
                        <p class="text-xs font-semibold tracking-[0.16em] text-[#8a7058] uppercase">
                            Host Summary
                        </p>
                        <div class="mt-4 flex items-start gap-4">
                            <img
                                :src="props.listing.host.avatarUrl"
                                :alt="props.listing.host.name"
                                class="h-16 w-16 rounded-2xl border border-[#e4d8c8] bg-[#f8f1e5] object-cover shadow-[0_10px_24px_rgba(77,53,31,0.08)]"
                            />
                            <div class="space-y-3">
                                <h2 class="text-2xl font-semibold text-[#221911]">
                                    {{ props.listing.host.name }}
                                </h2>
                                <p v-if="props.listing.host.headline" class="text-sm font-medium text-[#6b5848]">
                                    {{ props.listing.host.headline }}
                                </p>
                                <p v-if="props.listing.host.bio" class="text-sm leading-7 text-[#655648]">
                                    {{ props.listing.host.bio }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Occupation
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ props.listing.host.occupation ?? 'Not specified' }}
                                </p>
                            </div>
                            <div class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Work setup
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ props.listing.host.workSetup ?? 'Not specified' }}
                                </p>
                            </div>
                            <div class="rounded-[1.2rem] border border-[#e4d8c8] bg-[#fffdf8] px-4 py-4 sm:col-span-2">
                                <p class="text-xs font-semibold tracking-[0.14em] text-[#8a7058] uppercase">
                                    Host budget range
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#231a12]">
                                    {{ props.listing.host.budgetRange ?? 'Not specified' }}
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
                                More Listings
                            </p>
                            <h2 class="mt-2 text-2xl font-semibold text-[#221911]">
                                Related seeded options
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
                            v-for="relatedListing in props.relatedListings"
                            :key="relatedListing.id"
                            :href="show(relatedListing.id)"
                            class="rounded-[1.6rem] border border-[#e4d8c8] bg-[#fffdf8] p-5 transition hover:-translate-y-1 hover:shadow-[0_18px_40px_rgba(77,53,31,0.08)]"
                        >
                            <p class="text-sm font-medium text-[#8b7059]">
                                {{ relatedListing.district ? `${relatedListing.district}, ${relatedListing.city}` : relatedListing.city }}
                            </p>
                            <h3 class="mt-2 text-xl font-semibold text-[#221911]">
                                {{ relatedListing.title }}
                            </h3>
                            <p class="mt-3 text-sm leading-7 text-[#655648]">
                                {{ relatedListing.description }}
                            </p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    v-for="tag in relatedListing.tags.slice(0, 2)"
                                    :key="tag"
                                    class="rounded-full border border-[#ddcfbe] px-3 py-1.5 text-sm text-[#655648]"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                            <p class="mt-5 text-lg font-semibold text-[#231a12]">
                                {{ relatedListing.rent }}
                            </p>
                        </Link>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
