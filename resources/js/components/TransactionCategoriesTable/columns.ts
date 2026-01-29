import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

import DropdownAction from '@/components/TransactionCategoriesTable/DataTableDropDown.vue';
import TransactionCategory from '@/types/TransactionCategory';

export const columns: ColumnDef<TransactionCategory>[] = [
    {
        accessorKey: 'name',
        header: 'Category',
        cell: ({ row }) =>
            h('div', { class: 'capitalize' }, row.getValue('name')),
    },
    {
        accessorKey: 'type',
        header: () => h('div', {}, 'Category type'),
        cell: ({ row }) => {
            return h('div', { class: 'capitalize ' }, row.getValue('type'));
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const category = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    category,
                }),
            );
        },
    },
];
