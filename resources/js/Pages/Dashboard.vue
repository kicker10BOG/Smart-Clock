<script setup>
import { Link } from '@inertiajs/vue3'
import BasicPanel from '@/Components/BasicPanel.vue';
import LinkButton from '@/Components/LinkButton.vue'
import Icon from '@/Components/Icon.vue';
// import { route } from 'vendor/tightenco/ziggy/src/js';

const props = defineProps({
  clocks: {
    required: true,
    type: Array,
  }
})
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="flex flex-row mt-2">
      <LinkButton :href="route('clocks.create')" type="standard">Create Clock</LinkButton>
    </div>
    <div class="flex flex-row flex-wrap justify-between">
      <Link :href="route('clocks.show', { 'clock': clock.id })" v-for="(clock, i) in clocks" :key="clock.id"
        class="mt-2 mx-1 px-3 py-2 bg-gray-200 dark:bg-gray-800 glossy rounded-full">
      <Icon icon="clock" /> {{ clock.name }}
      </Link>
    </div>
  </div>
</template>
