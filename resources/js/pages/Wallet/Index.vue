<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { Wallet as WalletIcon } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import WalletsTable from '@/components/WalletsTable.vue';
import walletRoutes from '@/routes/wallets';
import type { Wallet } from '@/types/models/wallet';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Wallets',
                href: walletRoutes.index(),
            },
        ],
    },
});

defineProps<{
    wallets: Wallet[];
}>();
</script>

<template>
    <Head title="Wallets" />
    <div
        class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
    >
        <template v-if="wallets.length > 0">
            <div class="flex h-full w-full flex-col items-start gap-4">
                <ButtonGroup
                    ><ButtonGroup>
                        <Link :href="walletRoutes.create().url">
                            <Button variant="default"> New wallet</Button>
                        </Link>
                    </ButtonGroup>
                </ButtonGroup>

                <WalletsTable :wallets="wallets"></WalletsTable>
            </div>
        </template>
        <template v-else>
            <Empty class="grow-0 basis-auto">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <WalletIcon />
                    </EmptyMedia>
                    <EmptyTitle>No wallets yet!</EmptyTitle>
                    <EmptyDescription>
                        You haven't created any wallets yet. Get started by
                        creating your first wallet.
                    </EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <div class="flex gap-2">
                        <Link :href="walletRoutes.create().url">
                            <Button class="cursor-pointer"
                                >Create Wallet</Button
                            >
                        </Link>
                    </div>
                </EmptyContent>
            </Empty>
        </template>
    </div>
</template>
