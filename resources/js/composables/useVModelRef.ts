// composables/useVModelRef.ts
import { computed, type Ref } from 'vue';

/**
 * Transforme un Ref<T> en computed utilisable avec v-model
 */
export function useVModelRef<T>(source: Ref<T>) {
  return computed({
    get: () => source.value,
    set: (val: T) => {
      source.value = val;
    },
  });
}
