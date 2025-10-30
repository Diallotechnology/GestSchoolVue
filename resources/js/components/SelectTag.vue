<script setup lang="ts">
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command';
import Label from '@/components/ui/label/Label.vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Check, ChevronDown, X } from 'lucide-vue-next';
import type { PropType } from 'vue';
import { computed, ref, watch } from 'vue';
import Button from './ui/button/Button.vue';

interface Option {
    id: string | number;
    [key: string]: any;
}

const props = defineProps({
    modelValue: {
        type: Array as PropType<(string | number)[]>,
        required: true,
        default: () => [],
    },
    options: {
        type: Array as PropType<Option[]>,
        required: true,
        default: () => [],
    },
    placeholder: {
        type: String,
        default: 'Sélectionner...',
    },
    label: {
        type: String,
        default: 'name',
    },
});

const emit = defineEmits(['update:modelValue']);

const open = ref(false);
const selectedValues = ref<(string | number)[]>(props.modelValue);

watch(
    () => props.modelValue,
    (newVal) => {
        if (JSON.stringify(newVal) !== JSON.stringify(selectedValues.value)) {
            selectedValues.value = newVal;
        }
    },
    { immediate: true },
);

const selectedOptions = computed(() => props.options.filter((o) => selectedValues.value.includes(o.id)));

const handleSelect = (value: string | number) => {
    const index = selectedValues.value.indexOf(value);
    if (index === -1) {
        selectedValues.value = [...selectedValues.value, value];
    } else {
        selectedValues.value = selectedValues.value.filter((v) => v !== value);
    }
    emit('update:modelValue', selectedValues.value);
};

const removeTag = (id: string | number) => {
    selectedValues.value = selectedValues.value.filter((v) => v !== id);
    emit('update:modelValue', selectedValues.value);
};
</script>

<template>
    <div class="space-y-2">
        <Label v-if="$slots.default" for="multi-select-box">
            <slot></slot>
        </Label>
        <Popover v-model:open="open">
            <PopoverTrigger as-child>
                <Button
                    id="multi-select-box"
                    variant="outline"
                    role="combobox"
                    :aria-expanded="open"
                    class="my-2 w-full justify-between bg-background px-3 py-2 font-normal hover:bg-background"
                >
                    <div class="flex flex-wrap gap-1">
                        <template v-if="selectedOptions.length">
                            <span
                                v-for="opt in selectedOptions"
                                :key="opt.id"
                                class="flex items-center gap-1 rounded-lg bg-primary/10 px-2 py-0.5 text-sm text-primary"
                            >
                                {{ opt[label] ?? opt.name }}
                                <X class="cursor-pointer hover:text-red-500" :size="14" @click.stop="removeTag(opt.id)" />
                            </span>
                        </template>
                        <span v-else class="text-muted-foreground">
                            {{ placeholder }}
                        </span>
                    </div>
                    <ChevronDown :size="16" :stroke-width="2" class="shrink-0 text-muted-foreground/80" aria-hidden="true" />
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-full min-w-[var(--reka-popper-anchor-width)] p-0" align="start">
                <Command>
                    <CommandInput placeholder="Rechercher..." />
                    <CommandList>
                        <CommandEmpty>Aucun résultat.</CommandEmpty>
                        <CommandGroup>
                            <CommandItem v-for="option in options" :key="option.id" :value="option.id" @select="() => handleSelect(option.id)">
                                {{ option[label] ?? option.name }}
                                <Check v-if="selectedValues.includes(option.id)" :size="16" stroke-width="2" class="ml-auto" />
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                </Command>
            </PopoverContent>
        </Popover>
    </div>
</template>
