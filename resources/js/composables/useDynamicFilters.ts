// composables/useDynamicFilters.ts
import { ref, watch, type Ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useDebounce } from './useDebounce';

type DateRange = { start?: string | null; end?: string | null } | null;

interface FilterOptions<T> {
  controller: { index: (...args: any[]) => { url: string } };
  debounceKeys?: (keyof T)[];
  delay?: number;
  persist?: boolean;
  storageKey?: string; // sauvegarde dans localStorage
}

export function useDynamicFilters<T extends Record<string, any>>(
  initialFilters: T & { start?: string | null; end?: string | null },
  options: FilterOptions<T>,
) {
  const STORAGE_KEY = options.storageKey || 'filters';

  // 🔁 Restauration éventuelle depuis localStorage
  const saved = options.persist ? JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') : {};

  const filters = {} as { [K in keyof T]: Ref<T[K]> };

  for (const key in initialFilters) {
    const k = key as keyof T;
    filters[k] = ref((saved[key] ?? initialFilters[k]) as T[typeof k]);
  }

  const date = ref<DateRange>({
    start: saved.start ?? initialFilters.start ?? null,
    end: saved.end ?? initialFilters.end ?? null,
  });

  const dateModel = computed({
    get: () => date.value ?? { start: null, end: null },
    set: (val: DateRange) => (date.value = val),
  });

  const loading = ref(false);

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
    save();
    reload();
  }

  function save() {
    if (!options.persist) return;
    localStorage.setItem(
      STORAGE_KEY,
      JSON.stringify({
        ...Object.fromEntries(Object.entries(filters).map(([k, v]) => [k, v.value])),
        start: date.value?.start,
        end: date.value?.end,
      }),
    );
  }

  function reload() {
    const payload: Record<string, any> = {};

    for (const key in filters) {
      const k = key as keyof T;
      const source = debounced[k] ?? filters[k];

      // 👇 Cast explicite pour satisfaire TS
      payload[key as string] = source?.value ?? null;
    }

    payload.start = date.value?.start ?? null;
    payload.end = date.value?.end ?? null;

    router.get(options.controller.index().url, payload, {
      preserveState: true,
      replace: true,
    });
  }


  // Filtrage des champs texte / select
  for (const key in filters) {
    const k = key as keyof T;
    const src = debounced[k] ?? filters[k];
    watch(src, () => reload(), { deep: false });
  }

  // Filtrage date → une seule requête une fois les deux dates choisies
  const debouncedDate = useDebounce(date, 350);
  watch(
    debouncedDate,
    () => {
      if (debouncedDate.value?.start && debouncedDate.value?.end) reload();
      save();
    },
    { deep: true },
  );

  return { filters, dateModel, reload, reset, loading };
}
