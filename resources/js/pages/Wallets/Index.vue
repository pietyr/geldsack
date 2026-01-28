<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { Wallet as WalletIcon } from 'lucide-vue-next';

import WalletController from '@/actions/App/Http/Controllers/WalletController';
import EmptyCard from '@/components/EmptyCard.vue';
import { Button } from '@/components/ui/button';
import WalletsTable from '@/components/WalletsTable/WalletsTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Wallet from '@/types/Wallet';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wallets',
        href: WalletController.index().url,
    },
];

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
            <template v-if="wallets.length === 0"
                ><EmptyCard
                    :icon="WalletIcon"
                    :link="WalletController.create()"
                    button="Create wallet"
                    description="Create a new wallet to get started"
                    heading="No wallets yet"
            /></template>
            <template v-else>
                <div class="flex flex-row justify-center gap-10">
                    <WalletsTable
                        :wallets="wallets"
                        class="container w-fit"
                    ></WalletsTable>
                    <div>
                        <Link
                            :href="WalletController.create()"
                            class="cursor-pointer"
                        >
                            <Button>New wallet</Button></Link
                        >
                    </div>
                </div>
            </template>
        </div>
    </AppLayout>
</template>
