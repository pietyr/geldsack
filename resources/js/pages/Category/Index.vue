<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { ChartPie } from '@lucide/vue';
import { computed } from 'vue';
import CategoriesTable from '@/components/CategoriesTable.vue';
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

const props = defineProps<{
    categories: Category[];
}>();

const expenseCategories = computed(() => {
    return props.categories.filter((category) => category.type === 'expense');
});
const incomeCategories = computed(() => {
    return props.categories.filter((category) => category.type === 'income');
});
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
                <div class="w-full">
                    <CategoriesTable
                        :categories="expenseCategories"
                        type="expense"
                    ></CategoriesTable>
                </div>
                <div class="w-full">
                    <CategoriesTable
                        :categories="incomeCategories"
                        type="income"
                    ></CategoriesTable>
                </div>
            </div>
        </template>
        <template v-else>
            <Empty class="grow-0 basis-auto">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <ChartPie />
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
