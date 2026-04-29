import type { TransactionType } from '@/types/enums';

export interface Transaction {
    id: number;
    amount: string;
    type: TransactionType;
    category_id?: number;
    source_wallet_id?: number;
    destination_wallet_id?: number;
    date: string;
    description?: string;
    created_at?: string;
    updated_at?: string;
}
