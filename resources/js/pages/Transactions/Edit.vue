<script lang="ts" setup>
import { Form, Head, useForm } from '@inertiajs/vue3';
import { parseDate } from '@internationalized/date';
import { DateValue } from 'reka-ui';
import { computed, ref, watch } from 'vue';

import TransactionController from '@/actions/App/Http/Controllers/TransactionController';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from '@/components/ui/card';
import DatePicker from '@/components/ui/DatePicker.vue';
import { Input } from '@/components/ui/input';
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
import type Transaction from '@/types/Transaction';
import type TransactionCategory from '@/types/TransactionCategory';
import { TRANSACTION_TYPES } from '@/types/TransactionTypes';
import type Wallet from '@/types/Wallet';

const props = defineProps<{
    transaction: Transaction;
    categories: TransactionCategory[];
    wallets: Wallet[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: TransactionController.index().url,
    },
    {
        title: `Edit #${props.transaction.id}`,
        href: TransactionController.edit(props.transaction.id).url,
    },
];

const dateOnly = computed(() => {
    const raw = props.transaction.date as unknown as string;
    if (!raw) return '';
    return String(raw).slice(0, 10); // "YYYY-MM-DD"
});

const initialDateValue = computed<DateValue | undefined>(() => {
    if (!dateOnly.value) return undefined;
    return parseDate(dateOnly.value);
});

const form = useForm({
    date: dateOnly.value,
    wallet: String(props.transaction.wallet?.id ?? ''),
    type: props.transaction.type,
    category: String(props.transaction.category?.id ?? ''),
    amount: props.transaction.amount,
    description: props.transaction.description ?? '',
});

// UI state (pod Selecty)
const selectedType = ref<'income' | 'expense'>(form.type ?? '');
const selectedCategoryId = ref<string>(form.category ?? '');

const categoryById = computed<Map<string, TransactionCategory>>(() => {
    return new Map(
        props.categories.map((category) => [String(category.id), category]),
    );
});

const incomeCategories = computed(() => {
    return props.categories.filter((category) => category.type === 'income');
});

const expenseCategories = computed(() => {
    return props.categories.filter((category) => category.type === 'expense');
});

const filteredCategories = computed(() => {
    if (!selectedType.value) return props.categories;
    return props.categories.filter(
        (category) => category.type === selectedType.value,
    );
});

// Synchronizacja form <-> UI
watch(
    () => selectedType.value,
    (newType) => {
        form.type = newType;

        if (!selectedCategoryId.value) return;

        const cat = categoryById.value.get(selectedCategoryId.value);
        if (cat && cat.type !== newType) {
            selectedCategoryId.value = '';
            form.category = '';
        }
    },
);

watch(
    () => selectedCategoryId.value,
    (newId) => {
        form.category = newId;

        if (!newId) return;

        const cat = categoryById.value.get(newId);
        if (!cat) return;

        if (!selectedType.value) {
            selectedType.value = cat.type;
            return;
        }

        if (selectedType.value !== cat.type) {
            selectedType.value = cat.type;
        }
    },
);
</script>

<template>
    <Head title="Edit Transaction" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Form
                #default="{ errors }"
                :action="TransactionController.update(transaction)"
                method="patch"
            >
                <Card class="mx-auto w-full max-w-lg px-4">
                    <CardHeader>
                        <h4 class="text-2xl font-bold">Edit transaction</h4>
                    </CardHeader>

                    <CardContent class="space-y-4">
                        <div class="grid w-full items-center gap-4">
                            <div class="flex flex-col space-y-1.5">
                                <Label for="date">Transaction Date</Label>

                                <DatePicker
                                    id="date"
                                    :model-value="initialDateValue"
                                    class="w-full"
                                    name="date"
                                />

                                <div
                                    v-if="errors.date"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.date }}
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="wallet">Wallet</Label>
                                <Select
                                    id="wallet"
                                    v-model="form.wallet"
                                    class="w-full"
                                    name="wallet"
                                >
                                    <SelectTrigger class="w-full capitalize">
                                        <SelectValue
                                            placeholder="Select wallet"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Wallets</SelectLabel>
                                            <SelectItem
                                                v-for="wallet in wallets"
                                                :key="wallet.id"
                                                :value="String(wallet.id)"
                                                class="capitalize"
                                            >
                                                {{ wallet.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>

                                <div
                                    v-if="errors.wallet"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.wallet }}
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="transaction-type"
                                    >Transaction type</Label
                                >
                                <Select
                                    id="transaction-type"
                                    v-model="selectedType"
                                    class="w-full"
                                    name="type"
                                >
                                    <SelectTrigger class="w-full capitalize">
                                        <SelectValue
                                            placeholder="Select transaction type"
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

                            <div class="flex flex-col space-y-1.5">
                                <Label for="category">Category</Label>
                                <Select
                                    id="category"
                                    v-model="selectedCategoryId"
                                    class="w-full"
                                    name="category"
                                >
                                    <SelectTrigger class="w-full capitalize">
                                        <SelectValue
                                            placeholder="Select category"
                                        />
                                    </SelectTrigger>

                                    <SelectContent>
                                        <template v-if="selectedType">
                                            <SelectGroup>
                                                <SelectLabel class="capitalize">
                                                    {{ selectedType }}
                                                </SelectLabel>
                                                <SelectItem
                                                    v-for="category in filteredCategories"
                                                    :key="category.id"
                                                    :value="String(category.id)"
                                                    class="capitalize"
                                                >
                                                    {{ category.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </template>

                                        <template v-else>
                                            <SelectGroup>
                                                <SelectLabel class="capitalize"
                                                    >Income</SelectLabel
                                                >
                                                <SelectItem
                                                    v-for="category in incomeCategories"
                                                    :key="category.id"
                                                    :value="String(category.id)"
                                                    class="capitalize"
                                                >
                                                    {{ category.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                            <SelectGroup>
                                                <SelectLabel class="capitalize"
                                                    >Expense</SelectLabel
                                                >
                                                <SelectItem
                                                    v-for="category in expenseCategories"
                                                    :key="category.id"
                                                    :value="String(category.id)"
                                                    class="capitalize"
                                                >
                                                    {{ category.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </template>
                                    </SelectContent>
                                </Select>

                                <div
                                    v-if="errors.category"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.category }}
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="amount">Amount</Label>
                                <Input
                                    id="amount"
                                    v-model="form.amount"
                                    class="w-full"
                                    name="amount"
                                    placeholder="0.00"
                                    step="0.01"
                                    type="number"
                                />
                                <div
                                    v-if="errors.amount"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.amount }}
                                </div>
                            </div>

                            <div class="flex flex-col space-y-1.5">
                                <Label for="description">Description</Label>
                                <Input
                                    id="description"
                                    v-model="form.description"
                                    class="w-full"
                                    name="description"
                                    placeholder="Transaction description (optional)"
                                    type="text"
                                />
                                <div
                                    v-if="errors.description"
                                    class="font-medium text-red-600 italic"
                                >
                                    {{ errors.description }}
                                </div>
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
