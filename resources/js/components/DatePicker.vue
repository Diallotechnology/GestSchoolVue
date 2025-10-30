<!-- DatePickerField.vue -->
<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { parseDate } from '@internationalized/date';
import { Calendar as CalendarIcon } from 'lucide-vue-next';
import { ref, watch } from 'vue';
const props = withDefaults(
    defineProps<{
        modelValue: string | null;
        place?: string;
    }>(),
    {
        place: 'Sélectionner une date',
    },
);

const emit = defineEmits(['update:modelValue']);

const dateValue = ref();
const toDate = (calendarDate: any, timeZone: string): Date => {
    calendarDate.toDate(timeZone).toString().split('-'); // [YYYY, MM, DD]
    return new Date(calendarDate.toDate(timeZone));
};

// Initialisation
watch(
    () => props.modelValue,
    (newValue) => {
        if (newValue) {
            dateValue.value = parseDate(newValue);
        } else {
            dateValue.value = undefined;
        }
    },
    { immediate: true },
);

// Mise à jour du modèle
watch(dateValue, (newDateValue) => {
    if (newDateValue) {
        const jsDate = toDate(newDateValue, new Intl.DateTimeFormat().resolvedOptions().timeZone);
        emit('update:modelValue', jsDate.toISOString().split('T')[0]);
    } else {
        emit('update:modelValue', null);
    }
});

// Formatage d'affichage
const formatDisplay = (dateValue: any) => {
    if (!dateValue) return props.place;
    const jsDate = toDate(dateValue, new Intl.DateTimeFormat().resolvedOptions().timeZone);
    return jsDate.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" :class="cn('w-full justify-start text-left font-normal', !dateValue && 'text-muted-foreground')">
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{ formatDisplay(dateValue) }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar v-model="dateValue" initial-focus />
        </PopoverContent>
    </Popover>
</template>
