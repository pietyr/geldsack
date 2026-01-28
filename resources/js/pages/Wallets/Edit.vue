<script lang="ts" setup>
import { Form, Head, useForm } from '@inertiajs/vue3';

import WalletController from '@/actions/App/Http/Controllers/WalletController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Wallet from '@/types/Wallet';
import { computed } from 'vue';

const props = defineProps<{
    wallet: Wallet;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wallets',
        href: WalletController.index().url,
    },
    {
        title: props.wallet.name,
        href: WalletController.edit(props.wallet.id).url,
    },
];

const form = useForm({
    name: props.wallet.name,
    starting_balance: props.wallet.starting_balance,
    balance: props.wallet.balance,
});

const balance = computed(() => {
    return (
        props.wallet.balance -
        ((props.wallet.starting_balance ?? 0) - (form.starting_balance ?? 0))
    );
});
</script>

<template>
    <Head title="Edit Wallet" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form :action="WalletController.update(wallet)" method="patch">
                <Card class="mx-auto w-full max-w-lg px-4">
                    <CardHeader
                        ><h4 class="text-2xl font-bold">
                            Edit wallet
                        </h4></CardHeader
                    >
                    <CardContent class="space-y-4">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="wallet-name">Name</Label>
                                <Input
                                    id="wallet-name"
                                    v-model="form.name"
                                    name="name"
                                    placeholder="Wallet name"
                                    type="text"
                                />
                            </div>
                            <div class="flex flex-col space-y-1.5">
                                <Label for="wallet-balance"
                                    >Starting Balance</Label
                                >
                                <Input
                                    id="wallet-name"
                                    v-model="form.starting_balance"
                                    name="starting_balance"
                                    placeholder="Starting balance"
                                    type="number"
                                />
                            </div>
                            <div class="flex flex-col space-y-1.5">
                                <span>New balance: {{ balance }}</span>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end">
                        <Button class="w-full" type="submit">Save</Button>
                    </CardFooter>
                </Card>
            </Form>
        </div>
    </AppLayout>
</template>
