<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import {
    Empty,
    EmptyContent,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import categoriesRoutes from '@/routes/categories';
import type { Category } from '@/types/models/category';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Categories',
                href: categoriesRoutes.index(),
            },
        ],
    },
});

defineProps<{
    categories: Category[];
}>();
</script>

<template>
    <Head title="Categories" />
    <div
        class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
    >
        <template v-if="categories.length > 0">
            <div class="flex h-full w-full flex-col items-start gap-4">
                <ButtonGroup
                    ><ButtonGroup>
                        <Link :href="categoriesRoutes.create().url">
                            <Button variant="default"> Create category</Button>
                        </Link>
                    </ButtonGroup>
                </ButtonGroup>
            </div>
        </template>
        <template v-else>
            <Empty class="grow-0 basis-auto">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <CategoryIcon />
                    </EmptyMedia>
                    <EmptyTitle>No categories yet!</EmptyTitle>
                    <EmptyDescription>
                        You haven't created any categories yet. Get started by
                        creating your first category.
                    </EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <div class="flex gap-2">
                        <Link :href="categoriesRoutes.create().url">
                            <Button class="cursor-pointer"
                                >Create category</Button
                            >
                        </Link>
                    </div>
                </EmptyContent>
            </Empty>
        </template>
    </div>
</template>
