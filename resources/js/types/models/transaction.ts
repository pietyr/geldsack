import type { TransactionType } from '@/types/enums';
import type { Category } from '@/types/models/category';
import type { Wallet } from '@/types/models/wallet';

export interface Transaction {
    id: number;
    amount: string;
    type: TransactionType;
    date: string;
    category?: Category;
    sourceWallet?: Wallet;
    destinationWallet?: Wallet;
    description?: string;
    created_at?: string;
    updated_at?: string;
    user_id?: number;
}
