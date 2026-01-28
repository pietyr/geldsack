import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

import DropdownAction from '@/components/WalletsTable/DataTableDropDown.vue';
import Wallet from '@/types/Wallet';

export const columns: ColumnDef<Wallet>[] = [
    {
        accessorKey: 'name',
        header: 'Wallet',
        cell: ({ row }) =>
            h('div', { class: 'capitalize' }, row.getValue('name')),
    },
    {
        accessorKey: 'balance',
        header: () => h('div', { class: 'text-right' }, 'Balance'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('balance'));

            // Format the amount as a dollar amount
            const formatted = new Intl.NumberFormat('pl-PL', {
                style: 'currency',
                currency: 'PLN',
            }).format(amount);

            return h('div', { class: 'text-right font-medium ' }, formatted);
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const wallet = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    wallet,
                }),
            );
        },
    },
];
