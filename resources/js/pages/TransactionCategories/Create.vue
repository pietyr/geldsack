<script lang="ts" setup>
import { Form, Head } from '@inertiajs/vue3';

import TransactionCategoryController from '@/actions/App/Http/Controllers/TransactionCategoryController';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue
} from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { TRANSACTION_CATEGORY_TYPES } from '@/types/TransactionCategory';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: TransactionCategoryController.index().url,
    },
    {
        title: 'Create',
        href: TransactionCategoryController.create().url,
    },
];
</script>

<template>
    <Head title="Create Category" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                #default="{ errors }"
                :action="TransactionCategoryController.store()"
                method="post"
            >
                <Card class="mx-auto w-full max-w-lg px-4">
                    <CardHeader
                        ><h4 class="text-2xl font-bold">
                            Create category
                        </h4></CardHeader
                    >
                    <CardContent class="space-y-4">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="category-name">Name</Label>
                                <Input
                                    id="category-name"
                                    name="name"
                                    placeholder="Category name"
                                    type="text"
                                />
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
                                                v-for="type in TRANSACTION_CATEGORY_TYPES"
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
