<script lang="ts" setup>
import {
    Table,
    TableBody,
    TableCell,
    TableFooter,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

import type { Wallet } from '@/types/models/wallet';

defineProps<{
    wallets: Wallet[];
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead class="w-25" colspan="3"> Wallet </TableHead>
                <TableHead class="text-right"> Balance </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="wallet in wallets" :key="wallet.id">
                <TableCell class="font-medium" colspan="3">
                    {{ wallet.name }}
                </TableCell>
                <TableCell class="text-right"> 0 </TableCell>
            </TableRow>
        </TableBody>
        <TableFooter>
            <TableRow>
                <TableCell colspan="3"> Total </TableCell>
                <TableCell class="text-right"> $0 </TableCell>
            </TableRow>
        </TableFooter>
    </Table>
</template>

<style scoped></style>
