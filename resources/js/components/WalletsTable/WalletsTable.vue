<script lang="ts" setup>
import { columns } from '@/components/WalletsTable/columns';
import DataTable from '@/components/WalletsTable/DataTable.vue';
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
