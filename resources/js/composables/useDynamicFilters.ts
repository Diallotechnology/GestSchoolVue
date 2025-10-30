// composables/useDynamicFilters.ts
import { ref, watch, type Ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useDebounce } from './useDebounce';

type DateRange = { start?: string | null; end?: string | null } | null;

export function useDynamicFilters<T extends Record<string, any>>(
  initialFilters: T & { start?: string | null; end?: string | null },
  options: {
    controller: { index: (...args: any[]) => { url: string } };
    debounceKeys?: (keyof T)[];
    delay?: number;
    persist?: boolean;
  },
) {
  // ✅ filters est rempli immédiatement donc on peut le typer non-optional
  const filters = {} as { [K in keyof T]: Ref<T[K]> };

  const urlParams = new URLSearchParams(window.location.search);

  for (const key in initialFilters) {
    const k = key as keyof T;
    let value = initialFilters[k];

    if (options.persist && urlParams.has(key)) {
      value = (urlParams.get(key) as any) ?? initialFilters[k];
    }

    filters[k] = ref(value) as Ref<T[typeof k]>;
  }

  // 🔑 Gestion spéciale du range de dates
  const date = ref<DateRange>({
    start: (options.persist && urlParams.get('start')) || initialFilters.start || null,
    end: (options.persist && urlParams.get('end')) || initialFilters.end || null,
  });

  const dateModel = computed({
    get: () => date.value || { start: null, end: null },
    set: (val: DateRange) => {
      date.value = val;
    },
  });

  // Debounce
  const debounced: Partial<{ [K in keyof T]: Ref<any> }> = {};
  (options.debounceKeys ?? []).forEach((key) => {
    debounced[key] = useDebounce(filters[key], options.delay ?? 300);
  });

  function reset() {
    for (const key in initialFilters) {
      const k = key as keyof T;
      filters[k].value = initialFilters[k];
    }
    date.value = { start: null, end: null };
    reload();
  }

  function reload() {
    const payload: Record<string, any> = {};

    for (const key in filters) {
      const k = key as keyof T;
      payload[k as string] = debounced[k]?.value ?? filters[k].value ?? null;
    }

    payload.start = date.value?.start ?? null;
    payload.end = date.value?.end ?? null;

    router.get(options.controller.index().url, payload, {
      preserveState: true,
      replace: true,
    });
  }

  for (const key in filters) {
    const k = key as keyof T;
    const source = debounced[k] ?? filters[k];
    watch(source, reload);
  }
  watch(date, reload, { deep: true });

  return {
    filters,
    dateModel,
    reset,
    reload,
  };
}
