<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';

import TransactionCategoryController from '@/actions/App/Http/Controllers/TransactionCategoryController';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

const props = defineProps<{
    category: {
        id: string | number;
    };
}>();

const deleteOpen = ref(false);

function requestDelete() {
    deleteOpen.value = true;
}

function confirmDelete() {
    router.delete(
        TransactionCategoryController.destroy(Number(props.category.id)).url,
        {
            preserveScroll: true,
        },
    );
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button class="h-8 w-8 p-0" variant="ghost">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuSeparator />
            <Link
                :href="
                    TransactionCategoryController.edit(
                        Number(props.category.id),
                    ).url
                "
            >
                <DropdownMenuItem>Edit</DropdownMenuItem></Link
            >
            <DropdownMenuItem @click="requestDelete">Delete</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
    <AlertDialog v-model:open="deleteOpen">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Delete wallet?</AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone.
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction @click="confirmDelete"
                    >Delete</AlertDialogAction
                >
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<style scoped></style>
