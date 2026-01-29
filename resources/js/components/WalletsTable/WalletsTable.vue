<script lang="ts" setup>
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/WalletsTable/columns';
import Wallet from '@/types/Wallet';

defineProps<{
    wallets: Wallet[];
}>();
</script>

<template>
    <div>
        <DataTable :columns="columns" :data="wallets" />
    </div>
</template>

<style scoped></style>
