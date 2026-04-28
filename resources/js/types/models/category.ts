import type { CategoryType } from '@/types/enums';

export interface Category {
    id: number;
    name: string;
    type: CategoryType;
    user_id?: number;
    created_at?: string;
    updated_at?: string;
}
