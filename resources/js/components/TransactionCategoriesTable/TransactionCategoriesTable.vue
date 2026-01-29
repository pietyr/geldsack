<script lang="ts" setup>
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/TransactionCategoriesTable/columns';
import TransactionCategory from '@/types/TransactionCategory';

defineProps<{
    categories: TransactionCategory[];
}>();
</script>

<template>
    <div>
        <DataTable :columns="columns" :data="categories" />
    </div>
</template>

<style scoped></style>
