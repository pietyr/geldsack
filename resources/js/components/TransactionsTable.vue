<script lang="ts" setup>
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { formatDate } from '@/lib/utils';
import type { Transaction } from '@/types/models/transaction';

defineProps<{
    transactions: Transaction[];
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Date</TableHead>
                <TableHead>Type</TableHead>
                <TableHead>From wallet</TableHead>
                <TableHead>To wallet</TableHead>
                <TableHead>Category</TableHead>
                <TableHead>Amount</TableHead>
                <TableHead>Description</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="transaction in transactions" :key="transaction.id">
                <TableCell>{{ formatDate(transaction.date) }}</TableCell>
                <TableCell>{{ transaction.type }}</TableCell>
                <TableCell>{{
                    transaction.sourceWallet
                        ? transaction.sourceWallet.name
                        : '-'
                }}</TableCell>
                <TableCell>{{
                    transaction.destinationWallet
                        ? transaction.destinationWallet.name
                        : '-'
                }}</TableCell>
                <TableCell>
                    {{ transaction.category ? transaction.category.name : '-' }}
                </TableCell>
                <TableCell>
                    {{ transaction.amount }}
                </TableCell>
                <TableCell>{{ transaction.description ?? '' }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<style scoped></style>
