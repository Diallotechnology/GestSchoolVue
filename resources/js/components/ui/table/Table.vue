<script setup lang="ts">
import type { HTMLAttributes } from "vue"
import { cn } from "@/lib/utils"
import { PaginationLink } from "@/types";
import Pagination from "@/components/Pagination.vue";

const props = defineProps<{
  class?: HTMLAttributes["class"]
    rows?: PaginationLink[]
}>()
</script>

<template>
  <div data-slot="table-container" class="relative w-full overflow-auto">
    <table data-slot="table" :class="cn('w-full caption-bottom text-sm', props.class)">
      <slot />
    </table>
  </div>
      <div>
            <Pagination v-if="rows" :links="rows" class="my-2" />
        </div>
</template>
