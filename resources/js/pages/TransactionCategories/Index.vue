<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { ListTree as CategoryIcon } from 'lucide-vue-next';

import TransactionCategoryController from '@/actions/App/Http/Controllers/TransactionCategoryController';
import EmptyCard from '@/components/EmptyCard.vue';
import TransactionCategoriesTable from '@/components/TransactionCategoriesTable/TransactionCategoriesTable.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import TransactionCategory from '@/types/TransactionCategory';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: TransactionCategoryController.index().url,
    },
];

defineProps<{
    categories: TransactionCategory[];
}>();
</script>

<template>
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <template v-if="categories.length === 0"
                ><EmptyCard
                    :icon="CategoryIcon"
                    :link="TransactionCategoryController.create()"
                    button="Create category"
                    description="Create a new category to get started"
                    heading="No categories yet"
            /></template>
            <template v-else>
                <div>
                    <TransactionCategoriesTable :categories="categories" />
                </div>
                <div>
                    <Link
                        :href="TransactionCategoryController.create()"
                        class="cursor-pointer"
                    >
                        <Button>New category</Button></Link
                    >
                </div>
            </template>
        </div>
    </AppLayout>
</template>
