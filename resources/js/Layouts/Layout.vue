<script setup>
import Banner from '@/Components/Banner.vue';
import NavBar from '@/Components/Nav/NavBar.vue'
import Footer from '@/Components/Footer.vue'
import darkMode from '@/Stores/darkMode.js'
</script>

<template>
  <div class="w-full" :class="darkMode ? 'dark' : ''">
    <div class="flex flex-col bg-white dark:bg-black text-black dark:text-white" style="min-height: 100vh;">
      <NavBar sitename="Smart Clock" />
      <Banner />
      <div class="container flex flex-grow mx-auto">
        <slot />
      </div>
      <Footer />
    </div>
  </div>
</template>