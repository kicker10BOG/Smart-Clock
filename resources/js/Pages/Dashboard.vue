<script setup>
import LinkButton from '@/Components/LinkButton.vue'
</script>

<template>
  <div class="flex flex-col">
    <div class="flex flex-row">
    <LinkButton :href="route('clocks.create')">Create Clock</LinkButton>
  </div>
</div>
</template>
