<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRightLeft as TransactionIcon } from '@lucide/vue';
import { Button } from '@/components/ui/button';
import {
    Empty,
    EmptyContent,
    EmptyDescription,
    EmptyHeader,
    EmptyMedia,
    EmptyTitle,
} from '@/components/ui/empty';
import transactionsRoutes from '@/routes/transactions';
import type { Transaction } from '@/types/models/transaction';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Transactions',
                href: transactionsRoutes.index(),
            },
        ],
    },
});

defineProps<{
    transactions: Transaction[];
}>();
</script>

<template>
    <Head title="Transactions" />
    <div
        class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
    >
        <template v-if="transactions.length">
            <div class="flex h-full w-full flex-col items-start gap-4">
                <h4>TODO</h4>
                <p>Wallets table</p>
            </div>
        </template>
        <template v-else>
            <Empty class="grow-0 basis-auto">
                <EmptyHeader>
                    <EmptyMedia variant="icon">
                        <TransactionIcon />
                    </EmptyMedia>
                    <EmptyTitle>No transactions yet!</EmptyTitle>
                    <EmptyDescription>
                        You haven't made any transactions yet. Get started by
                        creating your first transaction.
                    </EmptyDescription>
                </EmptyHeader>
                <EmptyContent>
                    <div class="flex gap-2">
                        <Link :href="transactionsRoutes.create().url">
                            <Button class="cursor-pointer">
                                Create Transaction
                            </Button>
                        </Link>
                    </div>
                </EmptyContent>
            </Empty>
        </template>
    </div>
</template>
