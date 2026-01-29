import { TransactionType } from '@/types/TransactionTypes';

export default interface TransactionCategory {
    id: number;
    name: string;
    type: TransactionType;
}
