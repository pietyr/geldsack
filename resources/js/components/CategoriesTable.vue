<script lang="ts" setup>
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import type { CategoryType } from '@/types/enums';
import type { Category } from '@/types/models/category';

defineProps<{
    categories: Category[];
    type: CategoryType;
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableCaption class="text-lg capitalize">{{ type }}s</TableCaption>
            <TableRow>
                <TableHead class="w-25" colspan="4"> Category </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="category in categories" :key="category.id">
                <TableCell class="font-medium" colspan="4">
                    {{ category.name }}
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

<style scoped></style>
