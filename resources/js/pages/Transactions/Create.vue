<script lang="ts" setup>
import { Form, Head } from '@inertiajs/vue3';

import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from '@/components/ui/card';
import DatePicker from '@/components/ui/DatePicker.vue';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { TRANSACTION_TYPES } from '@/types/TransactionTypes';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: TransactionController.index().url,
    },
    {
        title: 'New',
        href: TransactionController.create().url,
    },
];
</script>

<template>
    <Head title="Add Transaction" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                #default="{ errors }"
                :action="TransactionController.store()"
                method="post"
            >
                <Card class="mx-auto w-full max-w-lg px-4">
                    <CardHeader
                        ><h4 class="text-2xl font-bold">
                            New transaction
                        </h4></CardHeader
                    >
                    <CardContent class="space-y-4">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="category-name"
                                    >Transaction Date</Label
                                >
                                <DatePicker class="w-full" name="date" />
                                <div
                                    v-if="errors.name"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.name }}
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1.5">
                                <Label for="category-type">Category type</Label>
                                <Select
                                    id="category-type"
                                    class="w-full"
                                    name="type"
                                >
                                    <SelectTrigger class="w-full capitalize">
                                        <SelectValue
                                            placeholder="Select category type"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Types</SelectLabel>
                                            <SelectItem
                                                v-for="type in TRANSACTION_TYPES"
                                                :key="type"
                                                :value="type"
                                                class="capitalize"
                                            >
                                                {{ type }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <div
                                    v-if="errors.type"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.type }}
                                </div>
                            </div>
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
