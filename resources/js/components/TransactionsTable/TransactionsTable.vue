<script lang="ts" setup>
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/TransactionsTable/columns';
import Transaction from '@/types/Transaction';


defineProps<{
    transactions: Transaction[];
}>();
</script>

<template>
    <div>
        <DataTable :columns="columns" :data="transactions" />
    </div>
</template>

<style scoped></style>
