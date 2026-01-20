<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import { Wallet as WalletIcon } from 'lucide-vue-next';

import WalletController from '@/actions/App/Http/Controllers/WalletController';
import EmptyCard from '@/components/EmptyCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wallets',
        href: WalletController.index().url,
    },
];

interface Wallet {
    id: number;
    name: string;
    balance: number;
}

defineProps<{
    wallets: Wallet[];
}>();
</script>

<template>
    <Head title="Create Wallet" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <template v-if="wallets.length === 0">
                <EmptyCard
                    :icon="WalletIcon"
                    :link="WalletController.create()"
                    button="Create wallet"
                    description="Create a new wallet to get started"
                    heading="No wallets yet"
                />
            </template>
            <template v-else> Tabela </template>
        </div>
    </AppLayout>
</template>
