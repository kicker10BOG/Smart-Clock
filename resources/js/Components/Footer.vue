<script setup>
// import { ref, onMounted, onUnmounted } from 'vue'
// import { Link } from '@inertiajs/vue3'


// import NavLink from '@/Components/Nav/NavLink.vue'
import SlideTransition from "@/Components/SlideTransition.vue";

import showNav from '@/Stores/showNav.js'
</script>

<template>
  <SlideTransition direction="up">
    <div v-if="showNav" class="flex flex-row justify-around h-8 w-full bg-gray-300 dark:bg-gray-700">
      <div class="flex flex-col justify-around">
        footer
      </div>
      <div class="flex flex-col justify-around">
        {{ $page.url }}
      </div>
    </div>
  </SlideTransition>
</template>