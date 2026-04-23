<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { browse as browsePosts } from '@/routes/posts';
import { create, edit, index } from '@/routes/roommate-posts';

type ManagedPost = {
    id: number;
    title: string;
    status: string;
    postType: string;
    city: string;
    district: string | null;
    budgetRange: string;
    moveInDate: string | null;
    updatedAt: string | null;
};

defineProps<{
    posts: ManagedPost[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'My posts',
                href: index(),
            },
        ],
    },
});
</script>

<template>
    <Head title="My posts" />

    <div class="space-y-6 p-4">
        <div class="flex flex-col gap-4 rounded-xl border border-sidebar-border/70 bg-background p-6 md:flex-row md:items-start md:justify-between">
            <Heading
                title="My roommate posts"
                description="Create, publish, and refine the posts people see before they message you."
            />

            <div class="flex flex-wrap gap-3">
                <Button variant="outline" as-child>
                    <Link :href="browsePosts()">Browse public posts</Link>
                </Button>
                <Button as-child>
                    <Link :href="create()">Create post</Link>
                </Button>
            </div>
        </div>

        <div v-if="posts.length > 0" class="grid gap-4 xl:grid-cols-2">
            <article
                v-for="post in posts"
                :key="post.id"
                class="rounded-xl border border-sidebar-border/70 bg-background p-5 shadow-xs"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-muted-foreground">
                            {{ post.district ? `${post.district}, ${post.city}` : post.city }}
                        </p>
                        <h2 class="mt-2 text-xl font-semibold tracking-tight">
                            {{ post.title }}
                        </h2>
                    </div>

                    <span class="rounded-full border border-sidebar-border px-3 py-1 text-xs font-medium text-muted-foreground">
                        {{ post.status }}
                    </span>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 text-sm text-muted-foreground">
                    <span class="rounded-full bg-muted px-3 py-1">{{ post.postType }}</span>
                    <span class="rounded-full bg-muted px-3 py-1">{{ post.budgetRange }}</span>
                    <span class="rounded-full bg-muted px-3 py-1">{{ post.moveInDate ?? 'Flexible move-in' }}</span>
                </div>

                <div class="mt-5 flex items-center justify-between gap-4 border-t border-sidebar-border/70 pt-4">
                    <p class="text-sm text-muted-foreground">
                        Updated {{ post.updatedAt ?? 'recently' }}
                    </p>

                    <Button variant="outline" as-child>
                        <Link :href="edit(post.id)">Edit post</Link>
                    </Button>
                </div>
            </article>
        </div>

        <div
            v-else
            class="rounded-xl border border-dashed border-sidebar-border/70 bg-background px-6 py-14 text-center"
        >
            <h2 class="text-lg font-semibold">No roommate posts yet</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Start with one post that explains your budget, target area, and move-in timing.
            </p>
            <div class="mt-5">
                <Button as-child>
                    <Link :href="create()">Create your first post</Link>
                </Button>
            </div>
        </div>
    </div>
</template>
