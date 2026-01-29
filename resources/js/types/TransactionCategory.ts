export const TRANSACTION_CATEGORY_TYPES = ['income', 'expense'] as const;

export default interface TransactionCategory {
    id: number;
    name: string;
    type: TransactionCategoryType;
}

export type TransactionCategoryType = (typeof TRANSACTION_CATEGORY_TYPES)[number];
