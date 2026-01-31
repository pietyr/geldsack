import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

import DropdownAction from '@/components/TransactionsTable/DataTableDropDown.vue';
import Transaction from '@/types/Transaction';

function formatDate(value: unknown): string {
    if (!value) return '';

    const d = new Date(value as string);
    if (Number.isNaN(d.getTime())) return String(value);

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear());

    return `${day}.${month}.${year} r.`;
}

function formatAmountPLN(value: unknown): string {
    const amount = Number.parseFloat(String(value));
    if (Number.isNaN(amount)) return String(value ?? '');

    return new Intl.NumberFormat('pl-PL', {
        style: 'currency',
        currency: 'PLN',
    }).format(amount);
}

export const columns: ColumnDef<Transaction>[] = [
    {
        accessorKey: 'date',
        header: 'Date',
        cell: ({ row }) => h('div', {}, formatDate(row.getValue('date'))),
    },
    {
        id: 'wallet',
        header: 'Wallet',
        accessorFn: (row) => row.wallet?.name ?? '',
        cell: ({ row }) => {
            const tx = row.original;
            return h('div', { class: 'capitalize' }, tx.wallet?.name ?? '');
        },
    },
    {
        id: 'category',
        header: 'Category',
        accessorFn: (row) => row.category?.name ?? '',
        cell: ({ row }) => {
            const tx = row.original;
            return h('div', { class: 'capitalize' }, tx.category?.name ?? '');
        },
    },
    {
        accessorKey: 'type',
        header: 'Type',
        cell: ({ row }) =>
            h(
                'div',
                { class: 'capitalize' },
                String(row.getValue('type') ?? ''),
            ),
    },
    {
        accessorKey: 'amount',
        header: () => h('div', { class: 'text-right' }, 'Amount'),
        cell: ({ row }) => {
            const tx = row.original;
            const isExpense = tx.type === 'expense';

            const formatted = formatAmountPLN(tx.amount);

            return h(
                'div',
                {
                    class: `text-right font-medium ${isExpense ? 'text-red-600' : 'text-green-600'}`,
                },
                `${isExpense ? '-' : '+'}${formatted}`,
            );
        },
    },
    {
        accessorKey: 'description',
        header: 'Description',
        cell: ({ row }) => {
            const val = row.getValue('description');
            return h(
                'div',
                { class: 'max-w-[280px] truncate' },
                String(val ?? ''),
            );
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const transaction = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(DropdownAction, {
                    transaction,
                }),
            );
        },
    },
];
