<script setup lang="ts">
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/components/ui/command';
import Label from '@/components/ui/label/Label.vue';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { Check, ChevronDown } from 'lucide-vue-next';
import type { PropType } from 'vue';
import { computed, ref, watch } from 'vue';
import Button from './ui/button/Button.vue';

interface Option {
    id: string | number;
    [key: string]: any; // permet d'accéder dynamiquement aux autres clés comme 'name', 'libelle', etc.
}

const props = defineProps({
    modelValue: {
        type: [String, Number] as PropType<string | number>,
        required: true,
        default: '',
    },
    options: {
        type: Array as PropType<Option[]>,
        required: true,
        default: () => [],
    },
    placeholder: {
        type: String,
        default: 'Select an option',
    },
    label: {
        type: String,
        default: 'name', // fallback si aucune clé n'est fournie
    },
});

const emit = defineEmits(['update:modelValue']);

const open = ref(false);
const selectedValue = ref(props.modelValue);
// Synchronisation unique et plus efficace
watch(
    () => props.modelValue,
    (newVal) => {
        if (newVal !== selectedValue.value) {
            selectedValue.value = newVal;
        }
    },
    { immediate: true },
);

const selectedOption = computed(() => {
    const found = props.options.find(
        (option) => option.id == selectedValue.value,
    );
    return found?.[props.label] ?? '';
});

const handleSelect = (value: string | number) => {
    if (selectedValue.value !== value) {
        selectedValue.value = value;
        emit('update:modelValue', value);
    }
    open.value = false;
};
</script>

<template>
    <div class="space-y-2">
        <Label v-if="$slots.default" for="select-box">
            <slot></slot>
        </Label>
        <Popover v-model:open="open">
            <PopoverTrigger as-child>
                <Button
                    id="select-box"
                    variant="outline"
                    role="combobox"
                    :aria-expanded="open"
                    class="my-2 w-full justify-between bg-background px-3 py-2 font-normal hover:bg-background"
                >
                    <span
                        :class="
                            cn(
                                'truncate',
                                !selectedValue && 'text-muted-foreground',
                            )
                        "
                    >
                        {{ selectedOption || placeholder }}
                    </span>
                    <ChevronDown
                        :size="16"
                        :stroke-width="2"
                        class="shrink-0 text-muted-foreground/80"
                        aria-hidden="true"
                    />
                </Button>
            </PopoverTrigger>
            <PopoverContent
                class="w-full min-w-[var(--reka-popper-anchor-width)] p-0"
                align="start"
            >
                <Command>
                    <CommandInput :placeholder="`Recherché un element...`" />
                    <CommandList>
                        <CommandEmpty>Aucun resultat.</CommandEmpty>
                        <CommandGroup>
                            <CommandItem
                                v-for="option in options"
                                :key="option.id"
                                :value="option.id"
                                @select="() => handleSelect(option.id)"
                            >
                                {{ option[label] ?? option.name }}
                                <Check
                                    v-if="selectedValue == option.id"
                                    :size="16"
                                    stroke-width="2"
                                    class="ml-auto"
                                />
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                </Command>
            </PopoverContent>
        </Popover>
    </div>
</template>
