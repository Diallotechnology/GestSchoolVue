// composables/useDebounce.ts
import { ref, watch, type Ref } from 'vue';

/**
 * Débounce une valeur réactive.
 * @param value La valeur à surveiller (ref)
 * @param delay Délai en ms (par défaut 300ms)
 */
export function useDebounce<T>(value: Ref<T>, delay = 300) {
  const debounced = ref<T>(value.value) as Ref<T>;
  let timeout: number | undefined;

  watch(
    value,
    (newVal) => {
      clearTimeout(timeout);
      timeout = window.setTimeout(() => {
        debounced.value = newVal;
      }, delay);
    },
    { immediate: true },
  );

  return debounced;
}
