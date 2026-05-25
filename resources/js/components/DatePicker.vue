<script lang="ts" setup>
import type { DateValue } from '@internationalized/date';
import {
    DateFormatter,
    getLocalTimeZone,
    today,
} from '@internationalized/date';

import { CalendarIcon } from '@lucide/vue';
import { computed } from 'vue';

import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';

const props = defineProps<{
    modelValue?: DateValue;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: DateValue | undefined): void;
}>();

const defaultPlaceholder = today(getLocalTimeZone());

const df = new DateFormatter('pl-PL', {
    dateStyle: 'long',
});

const date = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});
</script>

<template>
    <Popover v-slot="{ close }">
        <PopoverTrigger as-child>
            <Button
                :class="
                    cn(
                        'w-[240px] justify-start text-left font-normal',
                        !date && 'text-muted-foreground',
                    )
                "
                variant="outline"
            >
                <CalendarIcon />

                {{
                    date
                        ? df.format(date.toDate(getLocalTimeZone()))
                        : 'Pick a date'
                }}
            </Button>
        </PopoverTrigger>

        <PopoverContent align="start" class="w-auto p-0">
            <Calendar
                v-model="date"
                :default-placeholder="defaultPlaceholder"
                initial-focus
                layout="month-and-year"
                @update:model-value="close"
            />
        </PopoverContent>
    </Popover>
</template>
