<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { Receipt } from 'lucide-vue-next';

import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import EmptyCard from '@/components/EmptyCard.vue';
import TransactionsTable from '@/components/TransactionsTable/TransactionsTable.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Transaction from '@/types/Transaction';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: TransactionController.index().url,
    },
];

defineProps<{
    transactions: Transaction[];
}>();
</script>

<template>
    <Head title="Transactions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <template v-if="transactions.length === 0"
                ><EmptyCard
                    :icon="Receipt"
                    :link="TransactionController.create()"
                    button="New transaction"
                    description="Create your first transaction to get started"
                    heading="No transactions yet"
            /></template>
            <template v-else>
                <Link
                    :href="TransactionController.create()"
                    class="cursor-pointer"
                >
                    <Button>New transaction</Button></Link
                >
                <TransactionsTable
                    :transactions="transactions"
                ></TransactionsTable>
            </template>
        </div>
    </AppLayout>
</template>
