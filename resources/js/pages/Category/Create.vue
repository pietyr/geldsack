<script lang="ts" setup>
import { Form, Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import categoryRoutes, { store } from '@/routes/categories';
import type { CategoryType } from '@/types/enums';

defineProps<{
    types: CategoryType[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Categories',
                href: categoryRoutes.index(),
            },
            {
                title: 'Create',
                href: categoryRoutes.create(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Create category" />
    <Form #default="{ errors }" :action="store()" class="h-full" method="post">
        <div
            class="flex h-full flex-1 flex-row items-center justify-center gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Card class="w-full max-w-sm">
                <CardHeader>
                    <CardTitle>Create category</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="grid w-full items-center gap-4">
                        <div class="flex flex-col space-y-1.5">
                            <Label for="name">Category name</Label>
                            <Input
                                id="name"
                                name="name"
                                placeholder="e.g. Food"
                                type="text"
                            />
                            <div v-if="errors.name">
                                <span class="font-medium text-red-500 italic">{{
                                    errors.name
                                }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-1.5">
                            <Label>Category type</Label>
                            <RadioGroup default-value="expense" name="type">
                                <div
                                    v-for="type in types"
                                    :key="type"
                                    class="flex items-center space-x-2"
                                >
                                    <RadioGroupItem :id="type" :value="type" />
                                    <Label :for="type" class="capitalize">{{
                                        type
                                    }}</Label>
                                </div>
                            </RadioGroup>
                            <div v-if="errors.type">
                                <span class="font-medium text-red-500 italic">{{
                                    errors.type
                                }}</span>
                            </div>
                        </div>
                    </div>
                </CardContent>
                <CardFooter>
                    <Button class="w-full cursor-pointer" type="submit">
                        Create category
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </Form>
</template>
