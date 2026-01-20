<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import WalletController from '@/actions/App/Http/Controllers/WalletController';
import { type BreadcrumbItem } from '@/types';
import EmptyCard from '@/components/EmptyCard.vue';
import { Wallet as WalletIcon } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wallets',
        href: WalletController.index().url,
    },
];

interface Wallet{
    id: number;
    name: string;
    balance: number
}

defineProps<{
    wallets: Wallet[]
}>()
</script>

<template>
    <Head title="Dashboard" />

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
                 heading="No wallets yet"/>
            </template>
            <template v-else>
                Tabela
            </template>
        </div>
    </AppLayout>
</template>
