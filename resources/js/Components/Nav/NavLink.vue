<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
const props = defineProps({
  href: {
    type: String,
    default: null,
  },
  as: {
    type: String,
    default: "a",
  },
})

const page = usePage()
const current = computed(() => page.url == props.href)
</script>

<template>
  <Link :class="`flex rounded text-sm py-1 px-2 text-center cursor-pointer ${current
      ? 'bg-gray-300 dark:bg-gray-700 glossy'
      : 'hover:bg-gray-300 dark:hover:bg-gray-700 hover:glossy'
    }`" :href="href" :as="as">
    <span class="m-auto">
      <slot></slot>
    </span>
  </Link>
</template>
