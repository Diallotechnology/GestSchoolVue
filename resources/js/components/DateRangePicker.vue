<script setup lang="ts">
import type { DateRange } from 'reka-ui';
import type { Ref } from 'vue';

import { Button } from '@/components/ui/button';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { RangeCalendar } from '@/components/ui/range-calendar';

import { cn } from '@/lib/utils';
import { CalendarDate, DateFormatter, getLocalTimeZone } from '@internationalized/date';
import { Calendar as CalendarIcon } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const df = new DateFormatter('fr-FR', {
    dateStyle: 'medium',
});

// The component exposes v-model as { start?: string|null, end?: string|null } | null
type ModelValue = { start?: string | null; end?: string | null } | null;

const props = defineProps<{
    modelValue?: ModelValue;
}>();

const emit = defineEmits<(e: 'update:modelValue', value: ModelValue) => void>();

function isoToCalendarDate(iso?: string | null) {
    if (!iso) return undefined;
    const d = new Date(iso);
    if (isNaN(d.getTime())) return undefined;
    return new CalendarDate(d.getFullYear(), d.getMonth() + 1, d.getDate());
}

// Accept any date-like value that exposes toDate(), e.g. CalendarDate or CalendarDateTime
function calendarDateToISO(cd?: any) {
    if (!cd) return null;
    try {
        if (typeof cd.toDate === 'function') {
            const d = cd.toDate(getLocalTimeZone());
            return d.toISOString().slice(0, 10);
        }
        // Fallback: try to construct from string/date
        const maybe = new Date(cd);
        if (!isNaN(maybe.getTime())) return maybe.toISOString().slice(0, 10);
    } catch {
        // ignore
    }
    return null;
}

const local = ref<DateRange>({
    start: isoToCalendarDate(props.modelValue?.start) as any,
    end: isoToCalendarDate(props.modelValue?.end) as any,
}) as Ref<DateRange>;

// Sync incoming modelValue -> local
// Sync incoming modelValue -> local
watch(
    () => props.modelValue,
    (v) => {
        const start = isoToCalendarDate(v?.start) as any;
        const end = isoToCalendarDate(v?.end) as any;

        if (start?.toString() !== local.value.start?.toString() || end?.toString() !== local.value.end?.toString()) {
            local.value.start = start;
            local.value.end = end;
        }
    },
    { immediate: true },
);

// Emit when local selection changes
watch(
    local,
    (nv) => {
        const payload: ModelValue = {
            start: calendarDateToISO(nv.start),
            end: calendarDateToISO(nv.end),
        };

        // Vérifier que ça a réellement changé avant d'émettre
        if (payload.start !== props.modelValue?.start || payload.end !== props.modelValue?.end) {
            if (!payload.start && !payload.end) {
                emit('update:modelValue', null);
            } else {
                emit('update:modelValue', payload);
            }
        }
    },
    { deep: true },
);
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="cn('w-[280px] justify-start text-left font-normal', !(local && local.start) && 'text-muted-foreground')"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <template v-if="local.start">
                    <template v-if="local.end">
                        {{ df.format(local.start.toDate(getLocalTimeZone())) }} - {{ df.format(local.end.toDate(getLocalTimeZone())) }}
                    </template>

                    <template v-else>
                        {{ df.format(local.start.toDate(getLocalTimeZone())) }}
                    </template>
                </template>
                <template v-else> Trier par date </template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar v-model="local" initial-focus :number-of-months="2" />
        </PopoverContent>
    </Popover>
</template>
