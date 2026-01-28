<script lang="ts" setup>
import { Form, Head } from '@inertiajs/vue3';

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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wallets',
        href: WalletController.index().url,
    },
    {
        title: 'Create',
        href: WalletController.create().url,
    },
];
</script>

<template>
    <Head title="Create Wallet" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form :action="WalletController.store()" method="post">
                <Card class="mx-auto w-full max-w-lg px-4">
                    <CardHeader
                        ><h4 class="text-2xl font-bold">
                            Create wallet
                        </h4></CardHeader
                    >
                    <CardContent class="space-y-4">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="wallet-name">Name</Label>
                                <Input
                                    id="wallet-name"
                                    name="name"
                                    placeholder="Wallet name"
                                    type="text"
                                />
                            </div>
                            <div class="flex flex-col space-y-1.5">
                                <Label for="wallet-balance">Balance</Label>
                                <Input
                                    id="wallet-name"
                                    name="starting_balance"
                                    placeholder="Starting balance"
                                    type="number"
                                />
                            </div>
                            <div class="flex flex-col space-y-1.5"></div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-end">
                        <Button class="w-full" type="submit">Create</Button>
                    </CardFooter>
                </Card>
            </Form>
        </div>
    </AppLayout>
</template>
