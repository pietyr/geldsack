<script lang="ts" setup>
import type { DateValue } from '@internationalized/date';
import { DateFormatter, getLocalTimeZone, today } from '@internationalized/date';

import { CalendarIcon } from 'lucide-vue-next';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { computed, Ref, ref } from 'vue';

const defaultPlaceholder = today(getLocalTimeZone())
const date = ref() as Ref<DateValue>

const df = new DateFormatter('pl-PL', {
    dateStyle: 'long',
})

const props = defineProps<{
    name: string;
    modelValue?: DateValue;
}>();

const hiddenValue = computed(() => {
    return date.value ? date.value.toString(): '';
});
</script>

<template>
    <Popover v-slot="{ close }" class="w-full">
        <input :name="props.name" :value="hiddenValue" type="hidden">
        <PopoverTrigger as-child>
            <Button
                :class="cn('w-full justify-start text-left font-normal', !date && 'text-muted-foreground')"
                variant="outline"
            >
                <CalendarIcon />
                {{ date ? df.format(date.toDate(getLocalTimeZone())) : "Pick a date" }}
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
