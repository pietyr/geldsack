<script lang="ts" setup>
// defineProps<{}>()

import { Form, Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import walletRoutes, { store } from '@/routes/wallets';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Wallets',
                href: walletRoutes.index(),
            },
            {
                title: 'Create wallet',
                href: walletRoutes.create(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Create wallet" />
    <Form #default="{ errors }" :action="store()" class="h-full" method="post">
        <div
            class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle>Create wallet</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid w-full items-center gap-4">
                        <div class="flex flex-col space-y-1.5">
                            <Label for="name">Wallet name</Label>
                            <Input
                                id="name"
                                name="name"
                                placeholder="e.g. Cash"
                                type="text"
                            />
                            <div v-if="errors.name">
                                <span class="font-medium text-red-500 italic">{{
                                    errors.name
                                }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-1.5">
                            <Label for="starting_balance"
                                >Starting balance</Label
                            >
                            <Input
                                id="starting_balance"
                                name="starting_balance"
                                placeholder="0"
                                step="0.01"
                                type="number"
                            />
                            <div v-if="errors.starting_balance">
                                <span class="font-medium text-red-500 italic">{{
                                    errors.starting_balance
                                }}</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
                <CardFooter class="flex flex-col gap-2">
                    <Button class="w-full cursor-pointer" type="submit">
                        Create wallet
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </Form>
</template>
