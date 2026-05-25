<script lang="ts" setup>
import { Form, Head } from '@inertiajs/vue3';
import type { DateValue } from '@internationalized/date';
import { Ref, ref } from 'vue';
import DatePicker from '@/components/DatePicker.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import transactionRoutes from '@/routes/transactions';
import type { TransactionType } from '@/types/enums';
import type { Category } from '@/types/models/category';
import type { Wallet } from '@/types/models/wallet';

const props = defineProps<{
    categories: Category[];
    transactionType: TransactionType;
    wallets: Wallet[];
}>();

const selectedType = ref<TransactionType>(props.transactionType);
const destinationWalletId = ref<string | null>(null);
const selectedCategory = ref<Category | null>(null);
const date = ref() as Ref<DateValue>;

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Transactions',
                href: transactionRoutes.index(),
            },
            {
                title: 'Create',
                href: transactionRoutes.create(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Create transaction" />
    <div
        class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
    >
        <Tabs v-model="selectedType" :default-value="transactionType">
            <TabsList>
                <TabsTrigger value="expense">Expense</TabsTrigger>
                <TabsTrigger value="income">Income</TabsTrigger>
                <TabsTrigger value="transfer">Transfer</TabsTrigger>
            </TabsList>
            <TabsContent value="expense">
                <Form
                    #default="{ errors }"
                    :action="transactionRoutes.store()"
                    :transform="
                        (data) => ({
                            ...data,
                            type: selectedType,
                            destination_wallet_id: destinationWalletId,
                            category_id: selectedCategory,
                            date: date.toString(),
                        })
                    "
                    class="h-full"
                    method="post"
                >
                    <Card class="w-full max-w-sm">
                        <CardHeader>
                            <CardTitle> Create expense </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="grid w-full items-center gap-4">
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="wallet">Wallet</Label>
                                    <Select
                                        id="wallet"
                                        v-model="destinationWalletId"
                                    >
                                        <SelectTrigger class="w-full">
                                            <SelectValue
                                                placeholder="Select a wallet"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="wallet in wallets"
                                                :key="wallet.id"
                                                :value="wallet.id.toString()"
                                                >{{ wallet.name }}</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                    <div v-if="errors.destination_wallet_id">
                                        <span
                                            class="font-medium text-red-500 italic"
                                            >{{ errors.category_id }}</span
                                        >
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="category">Category</Label>
                                    <Select v-model="selectedCategory">
                                        <SelectTrigger class="w-full">
                                            <SelectValue
                                                placeholder="Select a category"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="category in categories"
                                                :key="category.id"
                                                :value="category.id.toString()"
                                                >{{ category.name }}</SelectItem
                                            >
                                        </SelectContent>
                                    </Select>
                                    <div v-if="errors.category_id">
                                        <span
                                            class="font-medium text-red-500 italic"
                                            >{{ errors.category_id }}</span
                                        >
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="date">Date</Label>
                                    <DatePicker v-model="date" />
                                </div>
                                <div class="flex flex-col space-y-1.5">
                                    <Label for="amount">Amount</Label>
                                    <Input
                                        id="amount"
                                        name="amount"
                                        placeholder="0"
                                        step="0.01"
                                        type="number"
                                    />
                                    <div v-if="errors.amount">
                                        <span
                                            class="font-medium text-red-500 italic"
                                            >{{ errors.amount }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Button class="w-full cursor-pointer" type="submit"
                                >Create Expense</Button
                            >
                        </CardFooter>
                    </Card>
                </Form>
            </TabsContent>
        </Tabs>
    </div>
</template>
