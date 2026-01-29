import TransactionCategory from '@/types/TransactionCategory';
import { TransactionType } from '@/types/TransactionTypes';
import Wallet from '@/types/Wallet';

export default interface Transaction {
    id: number;
    wallet: Wallet;
    amount: number;
    category: TransactionCategory;
    type: TransactionType;
    description: string;
    date: Date;
}
