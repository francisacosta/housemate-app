<script setup lang="ts">
import type { InertiaLinkProps } from '@inertiajs/vue3';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { dashboard, home, login, register } from '@/routes';
import { browse as browseListings } from '@/routes/listings';
import { browse as browsePosts } from '@/routes/posts';

type MatchStrategy = 'exact' | 'parent';

type PublicNavLink = {
    label: string;
    href: NonNullable<InertiaLinkProps['href']>;
    matchStrategy: MatchStrategy;
};

const page = usePage();
const { isCurrentOrParentUrl, isCurrentUrl } = useCurrentUrl();

const isAuthenticated = computed(() => Boolean(page.props.auth.user));

const navigationLinks: PublicNavLink[] = [
    {
        label: 'Home',
        href: home(),
        matchStrategy: 'exact',
    },
    {
        label: 'Browse Posts',
        href: browsePosts(),
        matchStrategy: 'parent',
    },
    {
        label: 'Browse Listings',
        href: browseListings(),
        matchStrategy: 'parent',
    },
];

const isActiveLink = (link: PublicNavLink): boolean =>
    link.matchStrategy === 'parent'
        ? isCurrentOrParentUrl(link.href)
        : isCurrentUrl(link.href);

const navigationLinkClasses = (link: PublicNavLink): string =>
    isActiveLink(link)
        ? 'bg-[#2f5d4f] text-white shadow-[0_10px_24px_rgba(47,93,79,0.18)]'
        : 'text-[#6a5748] hover:bg-[#efe3d2] hover:text-[#241c15]';
</script>

<template>
    <header class="px-6 pt-6 lg:px-10">
        <nav
            class="mx-auto flex max-w-7xl flex-col gap-3 rounded-[2rem] border border-[#d7c8b4] bg-[#fffaf2]/90 px-4 py-4 shadow-[0_12px_40px_rgba(77,53,31,0.08)] backdrop-blur sm:px-5 lg:flex-row lg:items-center lg:justify-between"
        >
            <div class="flex items-center justify-between gap-4">
                <Link
                    :href="home()"
                    class="text-sm font-semibold tracking-[0.24em] text-[#6e533b] uppercase"
                >
                    Housemate
                </Link>
            </div>

            <div class="flex flex-wrap items-center gap-2 text-sm">
                <Link
                    v-for="link in navigationLinks"
                    :key="link.label"
                    :href="link.href"
                    :aria-current="isActiveLink(link) ? 'page' : undefined"
                    prefetch
                    class="rounded-full px-4 py-2 font-medium transition"
                    :class="navigationLinkClasses(link)"
                >
                    {{ link.label }}
                </Link>
            </div>

            <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                <Link
                    v-if="isAuthenticated"
                    :href="dashboard()"
                    class="rounded-full border border-[#cdbca6] px-4 py-2 text-sm font-medium text-[#3d3025] transition hover:bg-[#f3e8d9]"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-full px-4 py-2 text-sm font-medium text-[#56473a] transition hover:bg-[#efe3d2]"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="register()"
                        class="rounded-full bg-[#241c15] px-4 py-2 text-sm font-medium text-[#fff9f2] transition hover:bg-[#3b2f24]"
                    >
                        Sign up
                    </Link>
                </template>
            </div>
        </nav>
    </header>
</template>
