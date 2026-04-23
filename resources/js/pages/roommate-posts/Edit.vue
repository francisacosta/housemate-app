<script setup lang="ts">
import { computed } from 'vue';
import { Form, Head, Link } from '@inertiajs/vue3';
import RoommatePostController from '@/actions/App/Http/Controllers/RoommatePostController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import { index } from '@/routes/roommate-posts';

type Option = {
    value: string;
    label: string;
};

type PostFormData = {
    id: number | null;
    title: string;
    description: string;
    status: string;
    postType: string;
    budgetMin: number | null;
    budgetMax: number | null;
    moveInDate: string | null;
    preferredPropertyType: string | null;
    region: string;
    province: string;
    cityMunicipality: string;
    districtOrBarangay: string | null;
    roommateIntent: string;
};

type Props = {
    mode: 'create' | 'edit';
    post: PostFormData;
    options: {
        statuses: Option[];
        postTypes: Option[];
        propertyTypes: Option[];
        roommateIntents: Option[];
    };
};

const props = defineProps<Props>();

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

const isCreateMode = computed(() => props.mode === 'create');
const pageTitle = computed(() =>
    isCreateMode.value ? 'Create roommate post' : 'Edit roommate post',
);

const pageDescription = computed(() =>
    isCreateMode.value
        ? 'Publish a practical summary of your budget, area, and roommate intent.'
        : 'Refine your roommate post so people can quickly understand the fit.',
);

const formBindings = computed(() =>
    isCreateMode.value
        ? RoommatePostController.store.form()
        : RoommatePostController.update.form(props.post.id!),
);

const selectClass =
    'border-input h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]';

const textareaClass =
    'border-input placeholder:text-muted-foreground min-h-32 w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]';
</script>

<template>
    <Head :title="pageTitle" />

    <div class="space-y-6 p-4">
        <div class="rounded-xl border border-sidebar-border/70 bg-background p-6">
            <Heading :title="pageTitle" :description="pageDescription" />
        </div>

        <Form v-bind="formBindings" class="space-y-6" v-slot="{ errors, processing }">
            <div class="rounded-xl border border-sidebar-border/70 bg-background p-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="grid gap-2 md:col-span-2">
                        <Label for="title">Post title</Label>
                        <Input id="title" name="title" :default-value="post.title" required maxlength="140" placeholder="Looking for one calm roommate to search with" />
                        <InputError :message="errors.title" />
                    </div>

                    <div class="grid gap-2 md:col-span-2">
                        <Label for="description">Description</Label>
                        <textarea
                            id="description"
                            name="description"
                            :value="post.description"
                            :class="cn(textareaClass)"
                            placeholder="Explain your move-in timing, target setup, and what kind of shared living feels right."
                            required
                        ></textarea>
                        <InputError :message="errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="post_type">Post type</Label>
                        <select id="post_type" name="post_type" :class="cn(selectClass)" :value="post.postType">
                            <option v-for="option in options.postTypes" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError :message="errors.post_type" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="status">Status</Label>
                        <select id="status" name="status" :class="cn(selectClass)" :value="post.status">
                            <option v-for="option in options.statuses" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError :message="errors.status" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="budget_min">Budget min (PHP)</Label>
                        <Input id="budget_min" name="budget_min" type="number" min="0" :default-value="post.budgetMin ?? undefined" placeholder="8000" />
                        <InputError :message="errors.budget_min" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="budget_max">Budget max (PHP)</Label>
                        <Input id="budget_max" name="budget_max" type="number" min="0" :default-value="post.budgetMax ?? undefined" placeholder="12000" />
                        <InputError :message="errors.budget_max" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="move_in_date">Move-in date</Label>
                        <Input id="move_in_date" name="move_in_date" type="date" :default-value="post.moveInDate ?? undefined" />
                        <InputError :message="errors.move_in_date" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="preferred_property_type">Preferred property type</Label>
                        <select id="preferred_property_type" name="preferred_property_type" :class="cn(selectClass)" :value="post.preferredPropertyType ?? ''">
                            <option value="">Flexible</option>
                            <option v-for="option in options.propertyTypes" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError :message="errors.preferred_property_type" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="roommate_intent">Roommate intent</Label>
                        <select id="roommate_intent" name="roommate_intent" :class="cn(selectClass)" :value="post.roommateIntent">
                            <option v-for="option in options.roommateIntents" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError :message="errors.roommate_intent" />
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 bg-background p-6">
                <Heading
                    variant="small"
                    title="Target area"
                    description="Keep the location practical and public-safe."
                />

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="region">Region</Label>
                        <Input id="region" name="region" :default-value="post.region" required placeholder="National Capital Region" />
                        <InputError :message="errors.region" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="province">Province</Label>
                        <Input id="province" name="province" :default-value="post.province" required placeholder="Metro Manila" />
                        <InputError :message="errors.province" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="city_municipality">City or municipality</Label>
                        <Input id="city_municipality" name="city_municipality" :default-value="post.cityMunicipality" required placeholder="Makati" />
                        <InputError :message="errors.city_municipality" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="district_or_barangay">District or barangay</Label>
                        <Input id="district_or_barangay" name="district_or_barangay" :default-value="post.districtOrBarangay ?? undefined" placeholder="Poblacion" />
                        <InputError :message="errors.district_or_barangay" />
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 pb-6">
                <Button :disabled="processing">
                    {{ isCreateMode ? 'Save post' : 'Update post' }}
                </Button>

                <Button variant="outline" as-child>
                    <Link :href="index()">Back to my posts</Link>
                </Button>
            </div>
        </Form>
    </div>
</template>
