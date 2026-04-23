<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { dashboard } from '@/routes';
import { create as createRoommatePost, index as roommatePostsIndex } from '@/routes/roommate-posts';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="rounded-xl border border-sidebar-border/70 bg-background p-6 dark:border-sidebar-border">
            <Heading
                title="Shared-living workspace"
                description="Manage your roommate posts and keep your public intent clear before messaging begins."
            />

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm font-medium">Create a post</p>
                    <p class="mt-2 text-sm text-muted-foreground">
                        Start a new roommate post with your target area, budget, and move-in timing.
                    </p>
                    <div class="mt-4">
                        <Button as-child>
                            <Link :href="createRoommatePost()">New post</Link>
                        </Button>
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm font-medium">Manage your posts</p>
                    <p class="mt-2 text-sm text-muted-foreground">
                        Review draft and published posts in one place.
                    </p>
                    <div class="mt-4">
                        <Button variant="outline" as-child>
                            <Link :href="roommatePostsIndex()">My posts</Link>
                        </Button>
                    </div>
                </div>

                <div class="rounded-xl border border-sidebar-border/70 p-5 dark:border-sidebar-border">
                    <p class="text-sm font-medium">Next up</p>
                    <p class="mt-2 text-sm text-muted-foreground">
                        Applications, interest matching, and messaging can plug into these posts next.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
