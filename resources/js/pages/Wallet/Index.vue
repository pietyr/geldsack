<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { Wallet as WalletIcon } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';
import walletRoutes from '@/routes/wallets';

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

const props = defineProps<{
    wallets: Array<any>;
}>();
</script>

<template>
    <Head title="Wallets" />

    <div
        class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
    >
        <template v-if="props.wallets.length > 0">
            <div>Zobacz portfele</div>
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
                        <Link :href="walletRoutes.create().url" as="button">
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
