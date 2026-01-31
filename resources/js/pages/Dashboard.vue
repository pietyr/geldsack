<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import {
    ListTree as CategoryIcon,
    Receipt,
    Wallet as WalletIcon,
} from 'lucide-vue-next';

import WalletController from '@/actions/App/Http/Controllers/WalletController';
import EmptyCard from '@/components/EmptyCard.vue';
import WalletsTable from '@/components/WalletsTable/WalletsTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Transaction from '@/types/Transaction';
import TransactionCategory from '@/types/TransactionCategory';
import Wallet from '@/types/Wallet';
import TransactionCategoryController from '@/actions/App/Http/Controllers/TransactionCategoryController';
import TransactionCategoriesTable from '@/components/TransactionCategoriesTable/TransactionCategoriesTable.vue';
import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import TransactionsTable from '@/components/TransactionsTable/TransactionsTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineProps<{
    wallets: Wallet[];
    transactions: Transaction[];
    categories: TransactionCategory[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div
                    class="relative flex aspect-video flex-col gap-4 overflow-y-auto rounded-xl border border-sidebar-border/70 p-4 md:p-4 dark:border-sidebar-border"
                >
                    <h4>Wallets</h4>
                    <template v-if="wallets.length === 0"
                        ><EmptyCard
                            :icon="WalletIcon"
                            :link="WalletController.create()"
                            button="Create wallet"
                            description="Create a new wallet to get started"
                            heading="No wallets yet"
                    /></template>
                    <template v-else>
                        <WalletsTable :wallets="wallets"></WalletsTable>
                    </template>
                </div>
                <div
                    class="relative flex aspect-video flex-col gap-4 overflow-y-auto rounded-xl border border-sidebar-border/70 p-4 md:p-4 dark:border-sidebar-border"
                >
                    <h4>Categories</h4>
                    <template v-if="categories.length === 0"
                        ><EmptyCard
                            :icon="CategoryIcon"
                            :link="TransactionCategoryController.create()"
                            button="Create category"
                            description="Create a new category to get started"
                            heading="No categories yet"
                    /></template>
                    <template v-else>
                        <TransactionCategoriesTable :categories="categories" />
                    </template>
                </div>
            </div>
            <div
                class="relative flex min-h-[100vh] flex-1 flex-col gap-4 overflow-y-auto rounded-xl border border-sidebar-border/70 p-4 md:min-h-min md:p-4 dark:border-sidebar-border"
            >
                <h4>Transactions</h4>
                <template v-if="transactions.length === 0"
                    ><EmptyCard
                        :icon="Receipt"
                        :link="TransactionController.create()"
                        button="New transaction"
                        description="Create your first transaction to get started"
                        heading="No transactions yet"
                /></template>
                <template v-else>
                    <TransactionsTable
                        :transactions="transactions"
                    ></TransactionsTable>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
