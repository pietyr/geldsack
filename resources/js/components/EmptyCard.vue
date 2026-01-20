<script lang="ts" setup>
import { LucideIcon } from 'lucide-vue-next';
import { Button } from '../components/ui/button';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '../components/ui/empty';
import { Link } from '@inertiajs/vue3';
import { RouteDefinition } from '@/wayfinder';

defineProps<{
    icon: LucideIcon;
    heading: string;
    description?: string
    button: string
    link: RouteDefinition<'get'>
}>();
</script>

<template>
    <Empty>
        <EmptyHeader>
            <EmptyMedia variant="icon">
                <component :is="icon" />
            </EmptyMedia>
        </EmptyHeader>
        <EmptyTitle>{{ heading }}</EmptyTitle>
        <EmptyDescription v-if="description">{{ description }}</EmptyDescription>
        <EmptyContent>
            <Link :href="link">
                <Button>{{ button }}</Button>
            </Link>

        </EmptyContent>
    </Empty>
</template>
