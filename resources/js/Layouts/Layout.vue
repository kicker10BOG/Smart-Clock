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
        <transition name="fade">
          <slot />
        </transition>
      </div>
      <Footer />
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease-in-out;
  width: 100%;
}
.fade-enter-active{
  transition-delay: 0.31s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  width: 100%;
}
</style>
